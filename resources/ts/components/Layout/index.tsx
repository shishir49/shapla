import React, { useEffect, useState } from "react";
import { Outlet } from "react-router-dom";
import { Box, SxProps } from "@mui/material";
import Topbar from "./Topbar";
import { useWindowSize } from "../../hooks/useWindowSize";
import { WindowSizes } from "../../constant";
import {
    sideBarWidth,
    topBarHeight,
    transitionDuration,
} from "./layout.config";

function Layout(props: any) {
    const size = useWindowSize();
    const [sideBarOpen, setSidebarOpen] = useState<boolean>(true);

    useEffect(() => {
        if (size === WindowSizes.LARGE) {
            setSidebarOpen(true);
        } else {
            setSidebarOpen(false);
        }
    }, [size]);

    const handleSidebarButton = () => {
        setSidebarOpen((o) => !o);
    };

    const containerStyle: SxProps = {
        marginTop: topBarHeight,
        marginLeft:
            size === WindowSizes.LARGE && sideBarOpen ? sideBarWidth : "0",
        padding: "1rem",
        transitionDuration: `${transitionDuration}ms`,
    };

    return (
        <Box>
            <Topbar onMenuButtonClick={handleSidebarButton} />
            {/* <Sidebar open={sideBarOpen} /> */}
            <Box sx={{ ...containerStyle }}>
                <Outlet />
            </Box>
        </Box>
    );
}

export default Layout;
