function previewMultipleImages(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById("image-previews");
    const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

    Array.from(files).forEach((file, index) => {
        if (file.size > maxFileSize) {
            alert(`File "${file.name}" exceeds 5MB size limit`);
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const imgContainer = document.createElement("div");
            imgContainer.classList.add("relative", "w-20", "h-20", "object-cover", "rounded-lg", "mb-2");

            const img = document.createElement("img");
            img.src = e.target.result;
            img.classList.add("w-20", "h-20","rounded-lg", "object-cover");

            const removeBtn = document.createElement("button");
            removeBtn.innerText = "X";
            removeBtn.classList.add("absolute", "top-0", "right-0", "bg-red-500", "text-white", "rounded-full", "p-1");
            removeBtn.onclick = function () {
                imgContainer.remove();
            };

            imgContainer.appendChild(img);
            imgContainer.appendChild(removeBtn);

            previewContainer.appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    });

    document.getElementById("upload-text-multiple").classList.add("hidden");
}
