import * as yup from "yup";

export const EmailValidation = yup
    .string()
    .email("Enter a valid email")
    .required("Email is required")

export const PasswordValidation = yup
    .string()
    .min(8, "Minimum 8 character is required")
    .required("Password is required")

export const PasswordConfirmValidation = (refField: string) => yup
    .string()
    .min(8, "Minimum 8 character is required")
    .oneOf([yup.ref(refField), null], 'Passwords must match')
    .required("Confirm Password is required")