var anhsp = document.getElementById("anhsp");
var anhsp_preview = document.getElementById("anhsp_preview");
let selectedFiles = [];

// Xóa ảnh preview
function clearImagePreview() {
    anhsp_preview.innerHTML = "";
}

// Tạo card ảnh preview
function createImagePreviewCard(file, index) {
    var cardContainer = document.createElement("div");
    cardContainer.className = "group-img card m-1";
    cardContainer.style.width = "30%";

    var cardBody = document.createElement("div");
    cardBody.className = "card-body";

    var img = document.createElement("img");
    img.className = "card-img-top";
    img.alt = "anhsp_preview";
    img.src = URL.createObjectURL(file);
    img.style.width = "100%";

    var fileName = document.createElement("p");
    fileName.className = "card-text";
    fileName.innerText = file.name;
    fileName.style.color = "black";
    fileName.style.overflow = "hidden";

    var deleteButton = document.createElement("button");
    deleteButton.className = "btn btn-danger";
    deleteButton.innerText = "Xóa ảnh";
    deleteButton.addEventListener("click", function () {
        // Xóa card và cập nhật danh sách file
        cardContainer.remove();
        updateFileInputValue(index);
    });

    cardBody.appendChild(img);
    cardBody.appendChild(fileName);
    cardContainer.appendChild(cardBody);
    cardContainer.appendChild(deleteButton);

    return cardContainer;
}

// Cập nhật giá trị input file
function updateFileInputValue(index) {
    selectedFiles.splice(index, 1);

    var dataTransfer = new DataTransfer();
    selectedFiles.forEach((file) => dataTransfer.items.add(file));
    anhsp.files = dataTransfer.files;
    anhsp.dispatchEvent(new Event("change"));
}

// Hiển thị ảnh preview cho tất cả các file được chọn
function displayImagePreview(files) {
    clearImagePreview();

    files.forEach(function (file, index) {
        if (file.type.startsWith("image/")) {
            var card = createImagePreviewCard(file, index);
            anhsp_preview.appendChild(card);
        } else {
            alert("Vui lòng chọn một tệp tin hình ảnh.");
            anhsp.value = "";
        }
    });
}

// Xử lý sự kiện thay đổi của input file
anhsp.addEventListener("change", function (evt) {
    var files = Array.from(anhsp.files);
    selectedFiles = files;
    displayImagePreview(files);
});

// Hàm chọn kích thước (size)
function selectSize(label) {
    var sizeOptions = document.querySelectorAll(".size-option");
    sizeOptions.forEach(function (option) {
        option.classList.remove("selected");
    });
    label.classList.add("selected");
}
