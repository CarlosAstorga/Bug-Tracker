import React from "react";

export default function Td({ tdClass, children }) {
    return (
        <td className={tdClass} style={{ whiteSpace: "nowrap" }}>
            {children}
        </td>
    );
}
