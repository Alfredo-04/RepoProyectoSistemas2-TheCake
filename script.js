document.addEventListener("DOMContentLoaded", function () {
    const counters = document.querySelectorAll(".menu-item");

    counters.forEach(item => {
        const minus = item.querySelector(".minus");
        const plus = item.querySelector(".plus");
        const count = item.querySelector(".count");

        minus.addEventListener("click", () => {
            let value = parseInt(count.textContent);
            if (value > 0) count.textContent = value - 1;
        });

        plus.addEventListener("click", () => {
            let value = parseInt(count.textContent);
            count.textContent = value + 1;
        });
    });
});
