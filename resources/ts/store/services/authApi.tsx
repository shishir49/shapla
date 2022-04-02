import { build } from "@reduxjs/toolkit/dist/query/core/buildMiddleware/cacheLifecycle";
import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
import { BaseURL } from "../../constant";
import {
    IUser,
    UserAuthResponse,
    UserLogin,
    UserPasswordReset,
} from "../../models/user.model";

export const authApi = createApi({
    reducerPath: "authApi",
    tagTypes: ["Auth"],
    baseQuery: fetchBaseQuery({ baseUrl: BaseURL }),
    endpoints: (build) => ({
        login: build.mutation<UserAuthResponse, UserLogin>({
            query(body) {
                return {
                    url: "login",
                    method: "POST",
                    body,
                };
            },
        }),
        forgotPassword: build.mutation<any, Pick<IUser, "email">>({
            query(body) {
                return {
                    url: "forgot-password",
                    method: "POST",
                    body,
                };
            },
        }),
        resetPassword: build.mutation<any, UserPasswordReset>({
            query(body) {
                return {
                    url: "reset-password",
                    method: "POST",
                    body,
                };
            },
        }),
    }),
});

export const {
    useLoginMutation,
    useForgotPasswordMutation,
    useResetPasswordMutation,
} = authApi;
