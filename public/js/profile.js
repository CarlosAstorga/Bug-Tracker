const label = document.getElementById("label");
const avatar = document.getElementById("avatar");
const imageInput = document.getElementById("imageInput");
const button = document.getElementById("submit");
button.addEventListener("click", e => {});
imageInput.addEventListener("change", () => {
    var reader = new FileReader();

    reader.readAsDataURL(imageInput.files[0]);
    reader.onload = function(e) {
        avatar.src = e.target.result;
        label.textContent = imageInput.files[0].name;
    };
});
