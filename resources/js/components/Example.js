import React, { useState, useEffect, useCallback } from "react";
import ReactDOM from "react-dom";
import SearchBar from "./searchBar";
import Paginator from "./Paginator";
import { users, tickets, projects } from "..";
import Button from "./Button";
import { isUndefined } from "lodash";

const BASE_URI = window.location.href;
const URL_TICKETS = "/tickets";
const URL_USERS = "/admin/users";
const URL_PROJECTS = "/projects";

const USER = "Usuario";
const DEVELOPER = "Desarrollador";
const ADMIN = "Administrador";
const MANAGER = "Lider de proyecto";

export default function Example({ sourceColumns, buttons, url, config }) {
    let tableConfig = {
        height: "657px",
        tableClass: null,
        baseClass: function() {
            return `table table-striped table-bordered ${this.tableClass}`;
        },
        header: null,
        idSearch: "search"
    };

    if (!isUndefined(config)) {
        tableConfig = { ...tableConfig, ...config };
    }
    const [records, setData] = useState([]);
    const [pagination, setPagination] = useState("");
    const [filter, setFilter] = useState("");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        search(filter);
    }, [search]);

    /**
     * Obtiene los registros correspondientes a la pagina solicitada.
     * @param {String} url
     */
    function page(url) {
        setLoading(true);
        axios(url).then(response => {
            setPagination(response.data);
            setData(response.data.data);
            setLoading(false);
        });
    }

    /**
     * Funcion debounce para las busquedas del usuario.
     */
    const search = useCallback(
        _.debounce(function(text) {
            getData(text);
        }, 1000),
        []
    );

    /**
     * Obtiene todos los registros paginados.
     * @param {String} filter
     */
    function getData(filter = null) {
        setFilter(filter);
        setLoading(true);
        const axiosInstance = filter
            ? axios(`${url}/list`, { params: { filter: filter } })
            : axios(`${url}/list`);
        axiosInstance.then(response => {
            setPagination(response.data);
            setData(response.data.data);
            setLoading(false);
        });
    }

    function convertToPlainText(record, column) {
        const { [0]: relation, [1]: field } = column.split(".");
        return Array.isArray(record[relation])
            ? record[relation].map(item => item[field]).join(" / ")
            : null;
    }

    return (
        <>
            <div className="row justify-content-between">
                <div className="col-sm-4">
                    <Paginator config={pagination} handlePagination={page} />
                </div>
                <div className="col-sm-6 col-md-4 mb-3">
                    <SearchBar
                        handleFilter={search}
                        filter={filter}
                        getData={getData}
                        id={tableConfig.idSearch}
                    />
                </div>
            </div>
            <div
                className="table-responsive"
                style={{ minHeight: tableConfig.height }}
            >
                <table className={tableConfig.baseClass()}>
                    <thead className="thead-dark">
                        {tableConfig.header && (
                            <tr>
                                <th
                                    className="bg-secondary"
                                    colSpan={sourceColumns.length + 1}
                                >
                                    {tableConfig.header}
                                </th>
                            </tr>
                        )}
                        <tr>
                            {sourceColumns.map(column => {
                                return (
                                    <th key={column.title}>{column.title}</th>
                                );
                            })}
                            {buttons.length > 0 && (
                                <th style={{ width: 10 + "%" }}>Acciones</th>
                            )}
                        </tr>
                    </thead>
                    <tbody>
                        {records.length > 0 ? (
                            records.map(row => {
                                return (
                                    <tr
                                        style={{ whiteSpace: "nowrap" }}
                                        key={row.id}
                                    >
                                        {sourceColumns.map(column => {
                                            return (
                                                <td key={column.name}>
                                                    {_.get(
                                                        row,
                                                        column.name,
                                                        convertToPlainText(
                                                            row,
                                                            column.name
                                                        )
                                                    )}
                                                </td>
                                            );
                                        })}
                                        {buttons.length > 0 && (
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
                                        )}
                                    </tr>
                                );
                            })
                        ) : (
                            <tr>
                                <td
                                    style={{ textAlign: "center" }}
                                    colSpan={sourceColumns.length + 1}
                                >
                                    {loading ? (
                                        <i>Cargando registros...</i>
                                    ) : (
                                        <i>No se encontraron registros</i>
                                    )}
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </>
    );
}

/**
 * 
                                                                
                             ,,                                 
`7MM"""Mq.                   db                    mm           
  MM   `MM.                                        MM           
  MM   ,M9 `7Mb,od8 ,pW"Wq.`7MM  .gP"Ya   ,p6"bo mmMMmm ,pP"Ybd 
  MMmmdM9    MM' "'6W'   `Wb MM ,M'   Yb 6M'  OO   MM   8I   `" 
  MM         MM    8M     M8 MM 8M"""""" 8M        MM   `YMMMa. 
  MM         MM    YA.   ,A9 MM YM.    , YM.    ,  MM   L.   I8 
.JMML.     .JMML.   `Ybmd9'  MM  `Mbmmd'  YMbmd'   `MbmoM9mmmP' 
                          QO MP                                 
                          `bmP                                  
 */

if (document.getElementById("projects")) {
    const container = document.getElementById("projects");
    const role = container.getAttribute("data-role");

    let buttons = [
        {
            cb: handleView,
            icon: "fas fa-eye"
        }
    ];

    if (role == "Administrador") {
        buttons = [
            ...buttons,
            {
                cb: handleEdit,
                icon: "fas fa-edit"
            },
            {
                cb: handleDelete,
                icon: "fas fa-trash"
            }
        ];
    }

    if (role == "Lider de proyecto") {
        buttons.push({
            cb: handleEdit,
            icon: "fas fa-edit"
        });
    }

    ReactDOM.render(
        <Example
            sourceColumns={projects()}
            buttons={buttons}
            url={URL_PROJECTS}
        />,
        container
    );
}

if (document.getElementById("projectUsers")) {
    const container = document.getElementById("projectUsers");
    let buttons = [];
    let config = { height: "367px", idSearch: "searchUsers" };

    ReactDOM.render(
        <Example
            sourceColumns={users()}
            buttons={buttons}
            url={BASE_URI + "/users"}
            config={config}
        />,
        container
    );
}

if (document.getElementById("projectTickets")) {
    const container = document.getElementById("projectTickets");
    let buttons = [{ cb: handleView, icon: "fas fa-eye" }];
    let config = { height: "367px", idSearch: "searchTickets" };

    ReactDOM.render(
        <Example
            sourceColumns={tickets()}
            buttons={buttons}
            url={BASE_URI + "/tickets"}
            config={config}
        />,
        container
    );
}

/**
 * 
             ,,                                        
MMP""MM""YMM db        `7MM               mm           
P'   MM   `7             MM               MM           
     MM    `7MM  ,p6"bo  MM  ,MP'.gP"Ya mmMMmm ,pP"Ybd 
     MM      MM 6M'  OO  MM ;Y  ,M'   Yb  MM   8I   `" 
     MM      MM 8M       MM;Mm  8M""""""  MM   `YMMMa. 
     MM      MM YM.    , MM `Mb.YM.    ,  MM   L.   I8 
   .JMML.  .JMML.YMbmd'.JMML. YA.`Mbmmd'  `MbmoM9mmmP' 
 */

if (document.getElementById("tickets")) {
    const container = document.getElementById("tickets");
    const role = container.getAttribute("data-role");

    let buttons = [{ cb: handleView, icon: "fas fa-eye" }];
    role != USER ? buttons.push({ cb: handleEdit, icon: "fas fa-edit" }) : null;
    role == ADMIN
        ? buttons.push({ cb: handleDelete, icon: "fas fa-trash" })
        : null;

    ReactDOM.render(
        <Example
            sourceColumns={tickets()}
            buttons={buttons}
            url={URL_TICKETS}
        />,
        container
    );
}

/**
 * 
`7MMF'   `7MF'                                
  MM       M                                  
  MM       M ,pP"Ybd  .gP"Ya `7Mb,od8 ,pP"Ybd 
  MM       M 8I   `" ,M'   Yb  MM' "' 8I   `" 
  MM       M `YMMMa. 8M""""""  MM     `YMMMa. 
  YM.     ,M L.   I8 YM.    ,  MM     L.   I8 
   `bmmmmd"' M9mmmP'  `Mbmmd'.JMML.   M9mmmP' 
 */
if (document.getElementById("users")) {
    const container = document.getElementById("users");
    const role = container.getAttribute("data-role");
    let buttons = [{ cb: handleEdit, icon: "fas fa-user-tag" }];

    if (role == "Administrador")
        buttons.push({ cb: handleDelete, icon: "fas fa-trash" });

    ReactDOM.render(
        <Example sourceColumns={users()} buttons={buttons} url={URL_USERS} />,
        container
    );
}

function handleEdit(url, id) {
    window.location = `${url}/${id}/edit`;
}

function handleView(url, id) {
    window.location = `${url}/${id}`;
}

function handleDelete(url, id) {
    if (confirm("Eliminar registro?")) {
        axios({
            method: "delete",
            url: `${url}/${id}`,
            data: {
                id
            }
        })
            .then((window.location = `${url}`))
            .catch(response => console.log(response));
    }
}
