function initTicket(numberOfFile, numberOfComments, ticketId, canDelete) {
    var filesCount = numberOfFile;
    var commentsCount = numberOfComments;
    var isSaving = false;
    const label = document.querySelector(".custom-file-label");
    const input = document.querySelector("input[type='file']");
    const button = document.getElementById("submitButton");
    const fileTable = document.getElementById("fileTable");
    const inputDesc = document.getElementById("inputDesc");
    const btnComment = document.getElementById("submitComment");
    const inputComment = document.getElementById("inputComment");
    const commentTable = document.getElementById("commentTable");

    const files = document.querySelectorAll(".flex-fill");

    function addListeners() {
        for (file of files) {
            let parent = file.parentNode.parentNode;
            let slug = parent.id.split("-").pop();

            let callback =
                parent.parentNode.id == "fileTable"
                    ? deleteFile
                    : deleteComment;
            file.addEventListener("click", () => callback(slug));
        }
    }

    addListeners();

    input.addEventListener("change", e => {
        label.textContent =
            input.files[0] != undefined
                ? input.files[0].name
                : "Seleccionar archivo";
    });
    button.addEventListener("click", () => {
        if (!isSaving) {
            isSaving = true;
            upload(input.files[0]);
        }
    });
    btnComment.addEventListener("click", () => {
        if (!isSaving) {
            isSaving = true;
            saveComment();
        }
    });

    function upload(file) {
        clearErrorMsg();
        isSaving = false;
        if (file == undefined)
            return showErrorMsg(input, "Ningun archivo seleccionado");
        if (!inputDesc.value)
            return showErrorMsg(
                inputDesc,
                "Debe agregar una descripción al archivo"
            );
        if (!file.type.startsWith("image/") && !file.type.endsWith("pdf"))
            return showErrorMsg(input, "Tipo de archivo no admitido");
        isSaving = true;

        let formData = new FormData();
        formData.append("file", file);
        formData.append("notes", inputDesc.value);
        formData.append("ticket_id", ticketId);
        fetchResponse("/file-upload", formData, addFile).then(
            res => (isSaving = false)
        );
    }

    function saveComment() {
        clearErrorMsg();
        if (!inputComment.value) {
            showErrorMsg(inputComment, "Debe agregar un comentario");
            return (isSaving = false);
        }

        let formData = new FormData();
        formData.append("message", inputComment.value);
        formData.append("ticket_id", ticketId);
        fetchResponse("/comment/store", formData, addComment).then(
            res => (isSaving = false)
        );
    }

    function fetchResponse(url, formData, success) {
        let isOk = true;
        let messages = "";
        return fetch(url, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": token
            }
        })
            .then(response => {
                if (!response.ok) isOk = false;
                return response.json();
            })
            .then(response => {
                if (!isOk) {
                    messages = response;
                    throw Error();
                }
                success(response);
            })
            .catch(error => {
                for (e in messages) {
                    showErrorMsg(
                        document.querySelector(`input[name=${e}]`),
                        messages[e]
                    );
                }
            });
    }

    function addComment(row) {
        if (commentsCount == 0) commentTable.innerHTML = "";
        inputComment.value = "";
        let tr = document.createElement("tr");
        tr.id = `comment-${row.id}`;
        tr.innerHTML = `
            <td>${row.submitter.name}</td>
            <td>${row.message}</td>
            <td>${row.created_at}</td>`;

        if (canDelete) {
            const td = document.createElement("td");
            const link = document.createElement("a");
            link.className = "flex-fill btn btn-light";
            link.style.lineHeight = 3;
            link.style.borderRadius = 0;
            link.addEventListener("click", () => deleteComment(row.id));
            link.innerHTML = `<i class="fas fa-trash"></i>`;
            td.className = "p-0 d-flex";
            td.appendChild(link);
            tr.appendChild(td);
        }
        commentTable.appendChild(tr);
        commentsCount++;
    }

    function addFile(row) {
        if (filesCount == 0) fileTable.innerHTML = "";
        inputDesc.value = "";
        input.value = null;
        label.textContent = "Seleccionar archivo";
        const tr = document.createElement("tr");
        tr.id = `file-${row.id}`;
        tr.innerHTML = `
                <td>
                <a href="/download/${row.id}">Descargar archivo</a>
                </td>
                <td>${row.notes}</td>
                <td>${row.uploader.name}</td>
                <td>${row.created_at}</td>`;

        if (canDelete) {
            const td = document.createElement("td");
            const link = document.createElement("a");
            link.className = "flex-fill btn btn-light";
            link.style.lineHeight = 3;
            link.style.borderRadius = 0;
            link.addEventListener("click", () => deleteFile(row.id));
            link.innerHTML = `<i class="fas fa-trash"></i>`;
            td.className = "p-0 d-flex";
            td.appendChild(link);
            tr.appendChild(td);
        }
        fileTable.appendChild(tr);
        filesCount++;
    }

    function showErrorMsg(element, error) {
        const span = document.createElement("span");
        span.className = "invalid-value";
        span.innerHTML = `<strong>${error}</strong>`;

        element.parentNode.parentNode.appendChild(span);
        element.className = element.className + " is-invalid";
    }

    function clearErrorMsg() {
        const elements = document.querySelectorAll(".invalid-value");
        const invalid = document.querySelectorAll(".is-invalid");
        for (let el of elements) {
            el.parentElement.removeChild(el);
        }

        for (let el of invalid) {
            el.classList.remove("is-invalid");
        }
    }

    function deleteFile(id) {
        fetch(`/file/${id}`, {
            method: "delete",
            body: {
                id
            },
            headers: {
                "X-CSRF-TOKEN": token
            }
        })
            .then(response => response.json())
            .then(success => {
                fileTable.removeChild(document.getElementById(`file-${id}`));
                filesCount--;
                if (filesCount == 0) {
                    fileTable.innerHTML = `<tr>
                    <td style="text-align: center;" colspan="5"><i>No se encontraron registros</i></td>
                </tr>`;
                }
            });
    }

    function deleteComment(id) {
        fetch(`/comment/${id}`, {
            method: "delete",
            body: {
                id
            },
            headers: {
                "X-CSRF-TOKEN": token
            }
        })
            .then(response => response.json())
            .then(success => {
                commentTable.removeChild(
                    document.getElementById(`comment-${id}`)
                );
                commentsCount--;
                if (commentsCount == 0) {
                    commentTable.innerHTML = `<tr>
                    <td style="text-align: center;" colspan="5"><i>No se encontraron registros</i></td>
                </tr>`;
                }
            });
    }
}
