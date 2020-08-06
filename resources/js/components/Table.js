import React, { useEffect, useContext } from "react";
import Tr from "./Tr";
import Button from "./Button";
import { tableDataContext } from "./Example";

export default function Table({ records }) {
    const { columns } = useContext(tableDataContext);
    return (
        <div className="table-responsive">
            <table className="table table-hover table-bordered">
                <thead className="thead-dark">
                    <tr>
                        {columns.map(column => {
                            return <th key={column.title}>{column.title}</th>;
                        })}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {records.map(row => {
                        return <Tr key={row.id} row={row} />;
                    })}
                </tbody>
            </table>
        </div>
    );
}
