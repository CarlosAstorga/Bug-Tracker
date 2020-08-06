import React, { useContext } from "react";
import Button from "./Button";
import Td from "./Td";
import { tableDataContext } from "./Example";

export default function Tr({ row }) {
    const { columns, buttons, url } = useContext(tableDataContext);
    function setText({ name }) {
        switch (true) {
            case name.includes("."):
                const relation = name.split(".");
                const text = _.get(row, name, row[relation[0]]);
                return Array.isArray(text)
                    ? text.map(item => item.title).join(" / ")
                    : text;
            default:
                return row[name];
        }
    }

    return (
        <tr>
            {columns.map((column, itemdex) => {
                return <Td key={itemdex} data={setText(column)} />;
            })}
            <td className="p-0 d-flex">
                {buttons.map(button => {
                    return (
                        <Button
                            key={button.icon}
                            id={row.id}
                            icon={button.icon}
                            cb={button.cb}
                            url={url}
                        />
                    );
                })}
            </td>
        </tr>
    );
}
