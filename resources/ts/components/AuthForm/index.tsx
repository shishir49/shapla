import React, { useEffect, useState } from "react";
import { Link, useLocation, useNavigate, useParams } from "react-router-dom";
import {
    Box,
    Button,
    CircularProgress,
    Grid,
    InputAdornment,
    InputProps,
    SxProps,
    TextField,
    Typography,
} from "@mui/material";
import { useDispatch } from "react-redux";
import { useFormik } from "formik";
import * as yup from "yup";
import { useSnackbar } from "notistack";
import VisibilityOffIcon from "@mui/icons-material/VisibilityOff";
import VisibilityIcon from "@mui/icons-material/Visibility";

import {
    useForgotPasswordMutation,
    useLoginMutation,
    useResetPasswordMutation,
} from "../../store/services/authApi";
import { UserLogin } from "../../models/user.model";
import { AuthForm, AuthFormType } from "../../constant";
import {
    EmailValidation,
    PasswordValidation,
    PasswordConfirmValidation,
} from "../../validations";
import { setToken } from "../../store/state/authSlice";

//Input variant
const variant = "standard";

//Styles
const styles: { [key: string]: SxProps } = {
    textField: {
        marginTop: "1rem",
        marginBottom: "1rem",
    },
};

//Form Title Map
const formTitle = {
    [AuthForm.LOGIN]: "Sign In",
    [AuthForm.FORGOT_PASSWORD]: "Forgot Password",
    [AuthForm.RESET_PASSWORD]: "Password Reset",
};

//Submit Button Name Map
const submitButtonName = {
    [AuthForm.LOGIN]: "Sign In",
    [AuthForm.FORGOT_PASSWORD]: "Send Reset Link",
    [AuthForm.RESET_PASSWORD]: "Reset Password",
};

function AuthFrom({ formType }: { formType: AuthFormType }) {
    const params = useParams();
    const location = useLocation();
    const navigate = useNavigate();
    const dispatch = useDispatch();

    const [passwordVisible, setPasswordVisible] = useState<
        { id: string; value: boolean }[]
    >([
        { id: "password", value: false },
        { id: "password_confirmation", value: false },
    ]);

    const [login] = useLoginMutation();
    const [forgotPassword] = useForgotPasswordMutation();
    const [resetPassword] = useResetPasswordMutation();

    const { enqueueSnackbar } = useSnackbar();

    //Validation Object for input validations
    const validationObject: any = {
        email: EmailValidation,
    };

    //initial form value
    const creds: any = { email: "" };

    switch (formType) {
        case AuthForm.LOGIN:
            creds.password = "";
            validationObject.password = PasswordValidation;
            break;
        case AuthForm.FORGOT_PASSWORD:
            creds.email = "";
            break;
        case AuthForm.RESET_PASSWORD:
            creds.password = "";
            creds.password_confirmation = "";
            validationObject.password = PasswordValidation;
            validationObject.password_confirmation =
                PasswordConfirmValidation("password");
            break;
        default:
            creds.password = "";
            validationObject.password = PasswordValidation;
            break;
    }

    //Input validation
    const validationSchema = yup.object(validationObject);

    //Initialize form
    const authForm = useFormik({
        initialValues: creds,
        validationSchema: validationSchema,
        onSubmit: (values) => {
            switch (formType) {
                case AuthForm.LOGIN:
                    return handleLogin(values);
                case AuthForm.FORGOT_PASSWORD:
                    return handleSendResetLink(values);
                case AuthForm.RESET_PASSWORD:
                    return handlePasswordReset(values);
                default:
                    return handleLogin(values);
            }
        },
    });

    //Reset form when location changes
    useEffect(() => {
        authForm.resetForm();
    }, [location]);

    //TextField Renderer
    const renderTextField = (
        identifier: string,
        label: string,
        type: React.HTMLInputTypeAttribute,
        inputProps?: Partial<InputProps>
    ) => {
        return (
            <TextField
                fullWidth
                required
                sx={{ ...styles.textField }}
                variant={variant}
                id={identifier}
                name={identifier}
                type={type}
                label={label}
                value={authForm.values[identifier]}
                onChange={authForm.handleChange}
                error={
                    (authForm.dirty || authForm.touched[identifier]) &&
                    !!authForm.errors[identifier]
                }
                helperText={
                    (authForm.dirty || authForm.touched[identifier]) &&
                    authForm.errors[identifier]
                }
                InputProps={inputProps}
            />
        );
    };

    const handleLogin = async (data: UserLogin) => {
        authForm.setSubmitting(true);
        login(data)
            .unwrap()
            .then((response) => {
                authForm.setSubmitting(false);
                enqueueSnackbar("Logged in successfully!", {
                    variant: "success",
                });
                authForm.resetForm({ values: creds });
                //Set Token
                dispatch(setToken(response));
                navigate("/");
            })
            .catch((error) => {
                authForm.setSubmitting(false);
                enqueueSnackbar(error.data.message, {
                    variant: "error",
                });
            });
    };

    const handleSendResetLink = (data: any) => {
        authForm.setSubmitting(true);
        forgotPassword(data)
            .unwrap()
            .then((response) => {
                authForm.setSubmitting(false);
                enqueueSnackbar(response.status, {
                    variant: "info",
                });
                authForm.resetForm({ values: creds });
            })
            .catch((error) => {
                authForm.setSubmitting(false);
                enqueueSnackbar(error.data.message, {
                    variant: "error",
                });
            });
    };

    const handlePasswordReset = (data: any) => {
        const dataWithToken = { ...data, token: params.token };
        authForm.setSubmitting(true);
        resetPassword(dataWithToken)
            .unwrap()
            .then((response) => {
                authForm.setSubmitting(false);
                enqueueSnackbar(response.message, {
                    variant: "success",
                });
                authForm.resetForm({ values: creds });
                navigate("/");
            })
            .catch((error) => {
                authForm.setSubmitting(false);
                enqueueSnackbar(error.data.message, {
                    variant: "error",
                });
            });
    };

    const renderPasswordFieldIcon = (id: string, position: "start" | "end") => {
        const visibleIndex = passwordVisible.findIndex((e) => e.id === id);
        if (visibleIndex >= 0) {
            return (
                <InputAdornment
                    position={position}
                    onClick={() => handleFieldIconClick(id)}
                    sx={{ ":hover": { cursor: "pointer" } }}
                >
                    {passwordVisible[visibleIndex].value ? (
                        <VisibilityIcon />
                    ) : (
                        <VisibilityOffIcon />
                    )}
                </InputAdornment>
            );
        }
    };

    const handleFieldIconClick = (id: string) => {
        const visibleIndex = passwordVisible.findIndex((e) => e.id === id);
        if (visibleIndex >= 0) {
            passwordVisible[visibleIndex].value =
                !passwordVisible[visibleIndex].value;
            setPasswordVisible([...passwordVisible]);
        }
    };

    return (
        <Box
            component={Grid}
            boxShadow={3}
            maxWidth="800px"
            minHeight="350px"
            container
            direction="column"
            justifyContent="space-evenly"
            alignItems="center"
            margin="1rem"
            padding="2rem"
            bgcolor="background.default"
            borderBottom="10px solid"
            borderColor="primary.dark"
        >
            <Typography
                variant="h4"
                fontWeight="700"
                align="center"
                color="primary.dark"
            >
                {formTitle[formType]}
            </Typography>

            <Box component="form" onSubmit={authForm.handleSubmit} width="100%">
                {renderTextField("email", "Email", "email")}

                {(formType === AuthForm.LOGIN ||
                    formType === AuthForm.RESET_PASSWORD) &&
                    formType !== AuthForm.FORGOT_PASSWORD &&
                    renderTextField(
                        "password",
                        "Password",
                        passwordVisible?.find((e) => e.id === "password")?.value
                            ? "text"
                            : "password",
                        {
                            endAdornment: renderPasswordFieldIcon(
                                "password",
                                "end"
                            ),
                        }
                    )}

                {formType !== AuthForm.LOGIN &&
                    formType !== AuthForm.FORGOT_PASSWORD &&
                    renderTextField(
                        "password_confirmation",
                        "Confirm Password",
                        passwordVisible?.find(
                            (e) => e.id === "password_confirmation"
                        )?.value
                            ? "text"
                            : "password",
                        {
                            endAdornment: renderPasswordFieldIcon(
                                "password_confirmation",
                                "end"
                            ),
                        }
                    )}

                <Box
                    component={Grid}
                    container
                    width="100%"
                    display="flex"
                    direction="row-reverse"
                    justifyContent="space-between"
                    alignItems="center"
                >
                    <Button
                        type="submit"
                        variant="contained"
                        sx={{ display: "flex", alignItems: "center" }}
                        disabled={
                            authForm.isSubmitting || !authForm.isValid
                                ? true
                                : false
                        }
                    >
                        {submitButtonName[formType]}

                        {authForm.isSubmitting && (
                            <CircularProgress
                                size={15}
                                sx={{ marginLeft: "0.5rem" }}
                            />
                        )}
                    </Button>
                    {formType === AuthForm.LOGIN && (
                        <Link to="/forgot-password">
                            <Typography variant="subtitle2" color="primary">
                                Forgot Password?
                            </Typography>
                        </Link>
                    )}
                </Box>
            </Box>
        </Box>
    );
}

export default AuthFrom;
