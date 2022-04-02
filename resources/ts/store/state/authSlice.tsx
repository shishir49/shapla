import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { UserAuthResponse } from "../../models/user.model";

const initialState: UserAuthResponse = { access_token: null, token_type: null };

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        setToken: (state, action: PayloadAction<UserAuthResponse>) => {
            state.access_token = action.payload.access_token;
            state.token_type = action.payload.token_type;
        },
    },
});

export const { setToken } = authSlice.actions;
export default authSlice.reducer;
