import "./bootstrap";
tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                sans: ["Plus Jakarta Sans", "sans-serif"],
            },
            colors: {
                primary: {
                    50: "#fef3e2",
                    100: "#fde5c2",
                    500: "#f97316", // Orange chaleureux
                    600: "#ea580c",
                    700: "#c2410c",
                },
                secondary: {
                    500: "#0f766e", // Teal profond
                    600: "#0d5c56",
                },
                sand: "#faf8f5",
            },
        },
    },
};
