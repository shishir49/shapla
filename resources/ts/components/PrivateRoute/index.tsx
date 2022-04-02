import React from "react";
import { Navigate } from "react-router-dom";

export interface IPrivateRouteProps {
  activate: boolean;
  redirectPath: string;
  Component: React.FC;
}

export const PrivateRoute: React.FC<IPrivateRouteProps> = (props) => {
  const { activate, redirectPath, Component, ...componentProps } = props;
  return activate ? (
    <Component {...componentProps} />
  ) : (
    <Navigate to={{ pathname: redirectPath }} />
  );
};

export default PrivateRoute;
