import React from "react";

export default function Col({ children, size }) {
    return <div className={size}>{children}</div>;
}
