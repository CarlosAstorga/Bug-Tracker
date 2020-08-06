import React from "react";
import Tr from "./Tr";

export default function Tbody({ data, columns }) {
    return (
        <tbody>
            {data.map((row, index) => {
                return <Tr key={index} row={row} columns={columns} />;
            })}
        </tbody>
    );
}
