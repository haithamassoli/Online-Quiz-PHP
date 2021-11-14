const start_btns = document.querySelectorAll(".start-btn");

let number_of_quiz;
start_btns.forEach((btn, index) => {
	btn.addEventListener("click", () => {
		number_of_quiz = "Quiz" + (index + 1);
		if (localStorage.getItem("quiz_number") === "") {
			localStorage.setItem("quiz_number", JSON.stringify(number_of_quiz));
		} else {
			localStorage.removeItem("quiz_number");
			localStorage.setItem("quiz_number", JSON.stringify(number_of_quiz));
		}
	});
});

