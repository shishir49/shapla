import React from "react";
import {
    AppBar,
    IconButton,
    SxProps,
    Toolbar,
    Typography,
} from "@mui/material";
import { topBarHeight } from "../layout.config";

function Topbar({ onMenuButtonClick }: any) {
    const styles: { [key: string]: SxProps } = {
        appBar: {
            height: topBarHeight,
            display: "flex",
            flexDirection: "row",
            alignItems: "center",
        },
    };

    return (
        <AppBar
            position="fixed"
            sx={{
                ...styles.appBar,
                zIndex: (theme) => theme.zIndex.drawer + 1,
            }}
        >
            <Toolbar>
                {/* <IconButton
                    size="large"
                    edge="start"
                    color="inherit"
                    sx={{ mr: 2 }}
                    onClick={onMenuButtonClick}
                >
                    <HiMenu />
                </IconButton> */}
                <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
                    Shapla
                </Typography>
            </Toolbar>
        </AppBar>
    );
}

export default Topbar;
