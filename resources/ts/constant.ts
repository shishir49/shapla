export const BaseURL = process.env.MIX_REACT_APP_BASEURL;

export const Colors = {
    primary: {
        main: '#2a4552',
        light: '#546a74',
        dark: '#1d3039',
        contrastText: '#fff'
    },
    secondary: {
        main: '#af2633',
        light: '#bf515b',
        dark: '#7a1a23',
        contrastText: '#fff'
    },
    error: {
        main: '#de0d0d',
        light: '#E43D3D',
        dark: '#9B0909',
        contrastText: '#fff'
    },
    warning: {
        main: '#ede209',
        light: '#F0E73A',
        dark: '#A59E06',
        contrastText: '#fff'
    },
    info: {
        main: '#0e86e6',
        light: '#3E9EEB',
        dark: '#095DA1',
        contrastText: '#fff'
    },
    success: {
        main: '#26ad2c',
        light: '#51BD56',
        dark: '#1A791E',
        contrastText: '#fff'
    },
    divider: '#2e2e2e',
}

export const WindowSizes = {
    LARGE: "LARGE",
    MOBILE: "MOBILE",
    TABLET: "TABLET"
}
export type WindowSize = typeof WindowSizes.LARGE | typeof WindowSizes.MOBILE | typeof WindowSizes.TABLET;

export const AuthForm = {
    LOGIN: "LOGIN",
    FORGOT_PASSWORD: "FORGOT_PASSWORD",
    RESET_PASSWORD: "RESET_PASSWORD"
}
export type AuthFormType = typeof AuthForm.LOGIN | typeof AuthForm.FORGOT_PASSWORD | typeof AuthForm.RESET_PASSWORD;