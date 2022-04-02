import React, { Suspense } from "react";
import ReactDOM from "react-dom";
import { Provider } from "react-redux";
import {
    BrowserRouter,
    Navigate,
    RouteObject,
    useRoutes,
} from "react-router-dom";
import { createTheme, responsiveFontSizes, ThemeProvider } from "@mui/material";
import { SnackbarProvider } from "notistack";
import { MUIThemeOptions, SnackbarProviderSettings } from "./config";
import { store } from "./store";

//CSS
import "../css/app.css";
import { AuthForm } from "./constant";

//Components
const Layout = React.lazy(() => import("./components/Layout"));
const Home = React.lazy(() => import("./containers/Home"));
const Auth = React.lazy(() => import("./containers/Auth"));

//Create theme
let theme = createTheme(MUIThemeOptions);
theme = responsiveFontSizes(theme);

function App() {
    const route: RouteObject[] = [
        {
            path: "/",
            element: <Layout />,
            children: [
                {
                    path: "",
                    element: <Navigate to={"auth"} />,
                },
                {
                    path: "home",
                    element: <Home />,
                },
            ],
        },
        {
            path: "auth",
            element: <Auth formType={AuthForm.LOGIN} />,
        },
        {
            path: "forgot-password",
            element: <Auth formType={AuthForm.FORGOT_PASSWORD} />,
        },
        {
            path: "reset-password/:token",
            element: <Auth formType={AuthForm.RESET_PASSWORD} />,
        },
    ];

    let routes = useRoutes(route);

    return <Suspense fallback={<></>}>{routes}</Suspense>;
}

export default App;

if (document.getElementById("root")) {
    ReactDOM.render(
        <React.StrictMode>
            <Provider store={store}>
                <ThemeProvider theme={theme}>
                    <SnackbarProvider {...SnackbarProviderSettings}>
                        <BrowserRouter>
                            <App />
                        </BrowserRouter>
                    </SnackbarProvider>
                </ThemeProvider>
            </Provider>
        </React.StrictMode>,
        document.getElementById("root")
    );
}
