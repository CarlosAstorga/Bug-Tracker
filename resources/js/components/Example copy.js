import React, { useState, useEffect, useCallback } from "react";
import ReactDOM from "react-dom";
import SearchBar from "./searchBar";
import Paginator from "./Paginator";
import Table from "./Table";
import Row from "./Row";
import Col from "./Col";
import { users, tickets } from "..";

const URL_TICKETS = "/tickets";
const URL_USERS = "/admin/users";
const URL_PROJECTS = "/projects";

export const tableDataContext = React.createContext();

// import { showMessage } from "../index.js";

export default function Example({ sourceColumns, buttons, url }) {
    const tableInfo = { columns: sourceColumns, buttons: buttons, url: url };
    const [dataModel, setData] = useState([]);
    const [pagination, setPagination] = useState("");
    const [filter, setFilter] = useState("");

    useEffect(() => {
        search(filter);
    }, [filter, search]);

    /**
     * Obtiene los registros correspondientes a la pagina solicitada.
     * @param {String} url
     */
    function page(url) {
        axios(url).then(response => {
            setPagination(response.data);
            setData(response.data.data);
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
        const axiosInstance = filter
            ? axios(`${url}/list`, { params: { filter: filter } })
            : axios(`${url}/list`);
        axiosInstance.then(response => {
            setPagination(response.data);
            // setData(createElementsfromData(response.data.data));
            setData(response.data.data);
        });
    }

    return (
        <>
            <Row css="row justify-content-between">
                <Col size="col-md-4">
                    <Paginator config={pagination} handlePagination={page} />
                </Col>
                <Col size="col-md-4">
                    <SearchBar handleFilter={search} />
                </Col>
            </Row>
            <tableDataContext.Provider value={tableInfo}>
                <Table records={dataModel} />
            </tableDataContext.Provider>
        </>
    );
}

// const url = document.location.href;

if (document.getElementById("projects")) {
    const container = document.getElementById("projects");
    const roles = container.getAttribute("data-user");

    let buttons = [
        {
            cb: id => {
                window.location = `${url}/${id}`;
            },
            icon: "fas fa-eye"
        }
    ];
    roles.includes("Administrador") || roles.includes("Gerente de proyecto")
        ? buttons.push({
              cb: () => {
                  console.log("X");
              },
              icon: "fas fa-users"
          })
        : null;

    ReactDOM.render(
        <Example
            sourceColumns={sourceColumns}
            buttons={buttons}
            url={document.location}
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
    let buttons = [{ cb: handleEdit, icon: "fas fa-edit" }];

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
    let buttons = [{ cb: handleEdit, icon: "fas fa-user-tag" }];

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
