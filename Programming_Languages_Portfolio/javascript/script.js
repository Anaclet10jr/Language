const form = document.getElementById("task-form");
const input = document.getElementById("task-input");
const list = document.getElementById("task-list");

form.addEventListener("submit", function (event) {
    event.preventDefault();

    const taskText = input.value.trim();
    if (taskText === "") return;

    const item = document.createElement("li");
    const text = document.createElement("span");
    text.textContent = taskText;

    const deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.addEventListener("click", function () {
        item.remove();
    });

    item.append(text, deleteButton);
    list.appendChild(item);
    input.value = "";
    input.focus();
});
