import React from "react";

export default function SearchBar({ handleFilter, filter, getData, id }) {
    function renderSearchButton(filter) {
        const searchButton = document.getElementById(id);
        return filter ? (
            <i
                role="button"
                onClick={() => {
                    getData();
                    searchButton.value = "";
                }}
                className="fas fa-times"
            ></i>
        ) : (
            <i className="fas fa-search"></i>
        );
    }
    return (
        <div className="input-group">
            <input
                id={id}
                onInput={evt => handleFilter(evt.target.value)}
                type="text"
                className="form-control"
                placeholder="Buscar.."
            />
            <div className="input-group-append">
                <span className="input-group-text">
                    {renderSearchButton(filter)}
                </span>
            </div>
        </div>
    );
}
