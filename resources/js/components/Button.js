import React from "react";

export default function Button({ id, icon, cb, url }) {
    return (
        <a
            className="flex-fill btn btn-light"
            style={{
                lineHeight: 3,
                borderRadius: 0
            }}
            onClick={() => cb(url, id)}
        >
            <i className={icon}></i>
        </a>
    );
}
