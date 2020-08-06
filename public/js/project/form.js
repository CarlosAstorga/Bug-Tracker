function initProjectForm(projectId) {
    let users = [];
    let records = [];
    const id = projectId;
    const ul = document.getElementById("userList");
    const icon = document.getElementById("icon");
    const tbody = document.getElementById("tbody");
    const iconList = document.getElementById("userListIcon");
    const searchBox = document.getElementById("search");
    const searchBoxUsers = document.getElementById("searchUsers");
    const fragment = document.createDocumentFragment();
    const tableFragment = document.createDocumentFragment();

    const handleSearch = _.debounce(function(e) {
        fetchUsers(e.target.value);
    }, 1000);

    icon.addEventListener("click", () =>
        clearInput(searchBoxUsers, handleAssignedUsers)
    );
    iconList.addEventListener("click", () => clearInput(searchBox, fetchUsers));
    searchBox.addEventListener("input", handleSearch);
    searchBoxUsers.addEventListener("input", () =>
        handleAssignedUsers(event.target.value)
    );

    function fetchUsers(filter = null) {
        changeIconBehavior(iconList, filter);

        let url = filter
            ? `/admin/users/list?filter=${filter}`
            : "/admin/users/list";
        fetch(url)
            .then(response => response.json())
            .then(response => {
                records = response.data;
                renderList(records);
            });
    }

    function renderList(data) {
        ul.innerHTML = "";
        data.forEach(row => {
            const li = document.createElement("LI");
            li.setAttribute("class", "list-group-item");
            li.innerHTML = `
                    <input id="${row.name}" class="form-check-input" type="checkbox" name="users[]" value="${row.id}">
                    <label for="${row.name}"><strong>${row.name}</strong><br><i>${row.join_roles}</i></label>`;
            li.firstElementChild.addEventListener("click", handleClick);

            users.find(user => user.id == row.id) !== undefined
                ? li.firstElementChild.setAttribute("checked", true)
                : null;

            fragment.appendChild(li);
        });
        ul.appendChild(fragment);
        removeChildren(fragment);
    }

    function handleClick(e) {
        const inputValue = e.target.value;
        const selectedItem = records.find(item => item.id == inputValue);

        if (e.target.checked) {
            users.push(selectedItem);
        } else {
            const index = users.findIndex(item => item.id == inputValue);
            users.splice(index, 1);
        }
        renderTable(users);
    }

    function renderTable(usersArray) {
        if (usersArray.length > 0) {
            tbody.innerHTML = "";
            usersArray.forEach(user => {
                const tr = document.createElement("TR");
                tr.style.whiteSpace = "nowrap";
                tr.innerHTML = `<td>${user.name}</td>
                        <td>${user.join_roles}</td>`;
                tableFragment.appendChild(tr);
            });
            tbody.appendChild(tableFragment);
            removeChildren(tableFragment);
        } else {
            tbody.innerHTML = `<tr>
                        <td style="text-align: center;" colspan="2"><i>No se encontraron usuarios asignados</i></td>
                    </tr>`;
        }
    }

    function handleAssignedUsers(filter) {
        changeIconBehavior(icon, filter);
        if (filter) {
            renderTable(
                users.filter(user => {
                    return (
                        `${user.name}`.includes(filter) ||
                        `${user.join_roles}`.includes(filter)
                    );
                })
            );
        } else {
            renderTable(users);
        }
    }

    function changeIconBehavior(element, value) {
        if (value) {
            element.className = "fas fa-times";
            element.setAttribute("role", "button");
        } else {
            element.className = "fas fa-search";
            element.removeAttribute("role");
        }
    }

    function clearInput(element, cb) {
        element.value = "";
        cb();
    }

    function removeChildren(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
    }

    if (id) {
        fetch(`/projects/${id}/users/list`)
            .then(response => response.json())
            .then(response => {
                users = response.data;
            })
            .then(() => {
                fetchUsers();
                renderTable(users);
            });
    } else {
        fetchUsers();
    }
}
