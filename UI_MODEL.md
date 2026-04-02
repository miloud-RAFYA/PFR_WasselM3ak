# UI Model / Template Guide for WasselM3ak

This document describes a **model** (structure + patterns) to improve, correct and adapt the UI of your Laravel project using the current template.

## 1) Base Layout (single source of truth)

### `resources/views/layouts/app.blade.php`
- Should include:
  - HTML `<head>` (meta, title, fonts, CSRF token, Tailwind)
  - A consistent **header/navigation** (desktop + mobile)
  - A `@yield('content')` area for page-specific content
  - A shared **footer** + modals (login/register) + scripts
- Keep all global UI styles (colors, fonts, spacing) here.

> ✅ Current file already has Tailwind + template header/footer. Keep improving here.

## 2) Shared UI components (reusable blocks)

Create small Blade components for repeated pieces:

- `resources/views/components/button.blade.php` (primary/secondary)
- `resources/views/components/card.blade.php`
- `resources/views/components/icon.blade.php` (Lucide wrapper)
- `resources/views/components/section-header.blade.php`

Use them like:
```blade
<x-button.primary>Commencer</x-button.primary>
```

## 3) Sections as building blocks

Store each major block in `resources/views/sections/`:
- `hero.blade.php`
- `how-it-works.blade.php`
- `features-client.blade.php`
- `features-driver.blade.php`
- `stats-bar.blade.php`
- etc.

Then the home page becomes:
```blade
@extends('layouts.app')

@section('content')
  @include('sections.hero')
  @include('sections.how-it-works')
  @include('sections.features-client')
  @include('sections.features-driver')
  ...
@endsection
```

## 4) Assets (images + icons)

Place images in:
- `public/images/` (PNG/SVG)

And reference with:
```blade
<img src="{{ asset('images/hero-delivery.png') }}" alt="...">
```

## 5) Tailwind + Theme colors

Keep your brand palette in one place:
- `resources/css/app.css` (via Tailwind config)
- OR inline `tailwind.config` (in `layouts/app.blade.php`)

Example palette:
```js
colors: {
  primary: {
    50: '#fff7ed',
    500: '#f97316',
    ...
  }
}
```

## 6) Recommended UI patterns (model)

### ✅ Navigation
- Mobile menu: off-canvas or dropdown
- User status: authenticated vs guest
- Always include a `Dashboard` link after login

### ✅ Cards + Grids
- Use `grid` or `flex` for responsive layout
- Use shared card component for uniform look

### ✅ Forms
- Build a single form component layout
- Maintain `@error` handling & old values

### ✅ Sections
Every section should:
1. Have a heading + subtitle
2. Be built using reusable components (button, card, icon)
3. Use consistent spacing + responsiveness

---

## Next steps (apply the model)
1. Align all existing pages to extend `layouts.app`
2. Convert repeated markup into Blade components
3. Use a consistent color + font system via Tailwind config
4. Replace placeholder blocks with real template images (done)

---

If you want, I can now:
- Scaffold the Blade components (button/card/section) and update your current views to use them
- Convert the current “menu + section blocks” into a reusable component library inside your project
- Build a stable layout system (header + footer + container) that matches the template perfectly
