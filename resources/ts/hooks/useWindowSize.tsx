import React, { useState, useEffect } from "react";
import { WindowSize, WindowSizes } from "../constant";

export function useWindowSize(): WindowSize {
    const [windowWidth, setWindowWidth] = useState(window.innerWidth);

    const handleResize = () => {
        setWindowWidth(window.innerWidth);
    };

    useEffect(() => {
        window.addEventListener("resize", handleResize);
        return () => window.removeEventListener("resize", handleResize);
    }, []);

    if (windowWidth > 1440) return WindowSizes.LARGE;
    else if (windowWidth < 768) return WindowSizes.MOBILE;
    else if (windowWidth >= 768 && windowWidth <= 1024)
        return WindowSizes.TABLET;
    else return WindowSizes.LARGE;
}
