// Função para desabilitar datas específicas
document.addEventListener("DOMContentLoaded", function () {
    const inputDate = document.getElementById("data");
    const unavailableDates = [
        "2024-12-10", // data indisponível
        "2024-12-7", // Outra data indisponível
        "2024-12-18"  // Mais uma data indisponível
    ];

    // Função para desabilitar as datas específicas
    inputDate.addEventListener("input", function () {
        const selectedDate = inputDate.value;
        if (unavailableDates.includes(selectedDate)) {
            alert("Esta data está indisponível. Por favor, escolha outra.");
            inputDate.value = ""; // Limpa o campo se a data escolhida for indisponível
        }
    });

     
});


