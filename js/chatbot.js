const toggleBtn = document.getElementById("chatbot-toggle");
const box = document.getElementById("chatbot-box");
const closeBtn = document.getElementById("chatbot-close");
const sendBtn = document.getElementById("chatbot-send");
const input = document.getElementById("chatbot-user-input");
const messages = document.querySelector(".chatbot-messages");

toggleBtn.onclick = () => {
    box.style.display = "flex";
};

closeBtn.onclick = () => {
    box.style.display = "none";
};

sendBtn.onclick = sendMessage;
input.addEventListener("keypress", (e) => {
    if (e.key === "Enter") sendMessage();
});

function sendMessage() {
    const text = input.value.trim();
    if (text === "") return;

    appendUserMessage(text);
    input.value = "";

    const typing = document.createElement("div");
    typing.className = "typing-indicator";
    typing.innerHTML = "<span></span><span></span><span></span>";
    messages.appendChild(typing);
    messages.scrollTop = messages.scrollHeight;

    fetch("handle_chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: text }),
    })
    .then(response => response.json())
    .then(data => {
        typing.remove(); 

        appendBotMessage(data.reply || "Sorry, no response.");
    })
    .catch(() => {
        typing.remove();
        appendBotMessage("Server error.");
    });
}

function appendUserMessage(text) {
    const div = document.createElement("div");
    div.className = "user-msg";
    div.textContent = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
}

function appendBotMessage(text) {
    const div = document.createElement("div");
    div.className = "bot-msg";
    div.textContent = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
}
