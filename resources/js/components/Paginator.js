import React from "react";

export default function Paginator({ config, handlePagination }) {
    const { prev_page_url, next_page_url } = config;
    const isPaginated =
        prev_page_url == null && next_page_url == null ? false : true;

    return (
        <>
            {isPaginated && (
                <ul className="pagination">
                    <li
                        className={
                            prev_page_url ? "page-item" : "page-item disabled"
                        }
                    >
                        <a
                            className="page-link"
                            onClick={evt => {
                                evt.preventDefault();
                                handlePagination(prev_page_url);
                            }}
                            href={prev_page_url}
                            rel="prev"
                        >
                            Previo
                        </a>
                    </li>
                    <li
                        className={
                            next_page_url ? "page-item" : "page-item disabled"
                        }
                    >
                        <a
                            className="page-link"
                            onClick={evt => {
                                evt.preventDefault();
                                handlePagination(next_page_url);
                            }}
                            href={next_page_url}
                            rel="next"
                        >
                            Siguiente
                        </a>
                    </li>
                </ul>
            )}
        </>
    );
}
