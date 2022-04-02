export interface IUser {
    id?: string;
    username: string;
    email: string;
    password: string;
    remember_me: string;
    forgot_password: string;
    status: string;
    created_by: string;
    email_verified_at: string;
    remember_token: string;
    created_at: string;
    updated_at: string;
}

export interface UserAuthResponse {
    access_token: string | null;
    token_type: string | null;
}

export interface UserPasswordReset extends UserPasswordResetType {
    token: string;
    password_confirmation: string;
}

export type UserLogin = Pick<IUser, "email" | "password">;
export type UserPasswordResetType = Pick<IUser, "email" | "password">;
