import React from "react";
import { Box } from "@mui/material";
import AuthFrom from "../../components/AuthForm";
import { AuthFormType } from "../../constant";

function Auth({ formType }: { formType: AuthFormType }) {
    return (
        <Box
            bgcolor="background.page"
            sx={{
                margin: 0,
                padding: 0,
                width: "100vw",
                height: "100vh",
                display: "flex",
                justifyContent: "center",
                alignItems: "center",
            }}
        >
            <AuthFrom formType={formType} />
        </Box>
    );
}

export default Auth;
