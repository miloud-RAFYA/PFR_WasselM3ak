<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Chauffeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    /**
     * Configuration des types de fichiers
     */
    protected array $imageMimes = ['jpg', 'jpeg', 'png', 'webp'];
    protected array $documentMimes = ['pdf', 'doc', 'docx'];
    protected int $maxFileSize = 5120; // 5MB

    /**
     * Upload un nouveau document
     */
    public function store(Request $request)
    {
        $request->validate([
            'chauffeur_id' => 'required|exists:chauffeurs,id',
            'type' => 'required|string',
            'fichier' => 'required|file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120',
        ]);

        try {
            $chauffeur = Chauffeur::findOrFail($request->chauffeur_id);
            $file = $request->file('fichier');
            
            // Déterminer le répertoire de stockage
            $directory = $this->getStorageDirectory($file->getClientOriginalExtension());
            
            // Générer un nom unique
            $fileName = $this->generateUniqueFileName($file->getClientOriginalName());
            
            // Stocker le fichier
            $path = $file->storeAs($directory, $fileName, 'public');
            
            // Créer le document en base de données
            $document = Document::create([
                'chauffeur_id' => $chauffeur->id,
                'type' => $request->type,
                'chemin' => $path,
                'status' => 'en_attente',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploadé avec succès',
                'document' => $document,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erreur upload document: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'upload: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Afficher les documents d'un chauffeur
     */
    public function index(Chauffeur $chauffeur)
    {
        $documents = $chauffeur->documents()->latest()->get();
        
        // Ajouter des informations sur chaque document
        $documents->transform(function ($doc) {
            $doc->file_exists = Storage::disk('public')->exists($doc->chemin);
            $doc->file_url = $doc->file_exists ? asset('storage/' . $doc->chemin) : null;
            $doc->file_type = $this->getFileType($doc->chemin);
            return $doc;
        });

        return response()->json([
            'success' => true,
            'documents' => $documents,
        ]);
    }

    /**
     * Valider un document
     */
    public function approve(Request $request, Document $document)
    {
        $request->validate([
            'commentaire' => 'nullable|string|max:500',
        ]);

        $document->update([
            'status' => 'approuve',
            'commentaire_admin' => $request->commentaire,
        ]);

        return back()->with('success', 'Document validé avec succès.');
    }

    /**
     * Rejeter un document
     */
    public function reject(Request $request, Document $document)
    {
        $request->validate([
            'commentaire' => 'required|string|max:500',
        ]);

        $document->update([
            'status' => 'rejete',
            'commentaire_admin' => $request->commentaire,
        ]);

        return back()->with('success', 'Document rejeté.');
    }

    /**
     * Supprimer un document
     */
    public function destroy(Document $document)
    {
        try {
            // Supprimer le fichier physique
            if (Storage::disk('public')->exists($document->chemin)) {
                Storage::disk('public')->delete($document->chemin);
            }

            $document->delete();

            return response()->json([
                'success' => true,
                'message' => 'Document supprimé avec succès',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
            ], 500);
        }
    }

    /**
     * Télécharger un document
     */
    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->chemin)) {
            abort(404, 'Fichier non trouvé');
        }

        return Storage::disk('public')->download(
            $document->chemin,
            $document->type . '_' . $document->id . '.' . pathinfo($document->chemin, PATHINFO_EXTENSION)
        );
    }

    /**
     * Déterminer le répertoire de stockage selon le type de fichier
     */
    protected function getStorageDirectory(string $extension): string
    {
        $extension = strtolower($extension);
        
        if (in_array($extension, $this->imageMimes)) {
            return 'images';
        }
        
        return 'documents';
    }

    /**
     * Générer un nom de fichier unique
     */
    protected function generateUniqueFileName(string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        
        // Nettoyer le nom
        $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $baseName);
        
        // Ajouter un timestamp et un identifiant unique
        return sprintf(
            '%s_%s_%s.%s',
            $baseName,
            time(),
            uniqid(),
            $extension
        );
    }

    /**
     * Obtenir le type de fichier
     */
    protected function getFileType(string $path): string
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        if (in_array($extension, $this->imageMimes)) {
            return 'image';
        }
        
        if ($extension === 'pdf') {
            return 'pdf';
        }
        
        return 'document';
    }
}
