import { ThemeOptions } from "@mui/material";
import { SnackbarProviderProps } from "notistack";
import { Colors } from "./constant";

export const MUIThemeOptions: ThemeOptions = {
    typography: {
        fontFamily: [
            "Lato",
        ].join(",")
    },
    palette: {
        mode: 'light',
        primary: {
            main: Colors.primary.main,
            light: Colors.primary.light,
            dark: Colors.primary.dark,
            contrastText: Colors.primary.contrastText
        },
        secondary: {
            main: Colors.secondary.main,
            light: Colors.secondary.light,
            dark: Colors.secondary.dark,
            contrastText: Colors.secondary.contrastText
        },
        error: {
            main: Colors.error.main,
            light: Colors.error.light,
            dark: Colors.error.dark,
            contrastText: Colors.error.contrastText
        },
        warning: {
            main: Colors.warning.main,
            light: Colors.warning.light,
            dark: Colors.warning.dark,
            contrastText: Colors.warning.contrastText
        },
        info: {
            main: Colors.info.main,
            light: Colors.info.light,
            dark: Colors.info.dark,
            contrastText: Colors.info.contrastText
        },
        success: {
            main: Colors.success.main,
            light: Colors.success.light,
            dark: Colors.success.dark,
            contrastText: Colors.success.contrastText
        },
        divider: Colors.divider,
    }
}

export const SnackbarProviderSettings: Partial<SnackbarProviderProps> = {
    maxSnack: 5,
    anchorOrigin: {
        vertical: "bottom",
        horizontal: "right",
    },
    autoHideDuration: 2000,
    preventDuplicate: true,
}