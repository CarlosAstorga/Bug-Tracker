import React from "react";

export default function Row({ children, css }) {
    return <div className={css}>{children}</div>;
}
