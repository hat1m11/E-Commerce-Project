const toggleBtn = document.getElementById("chatbot-toggle");
const chatBox = document.getElementById("chatbot-box");
const sendBtn = document.getElementById("chatbot-send");
const input = document.getElementById("chatbot-user-input");
const messages = document.querySelector(".chatbot-messages");

toggleBtn.addEventListener("click", () => {
    chatBox.style.display = chatBox.style.display === "flex" ? "none" : "flex";
});

// Send message
sendBtn.addEventListener("click", sendMessage);
input.addEventListener("keypress", e => {
    if (e.key === "Enter") sendMessage();
});

function sendMessage() {
    const text = input.value.trim();
    if (!text) return;

    addMessage("user", text);
    input.value = "";

    // Send to backend
    fetch("/chatbot/handle_chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: text })
    })
    .then(res => res.json())
    .then(data => {
        addMessage("bot", data.reply);
    });
}

function addMessage(sender, text) {
    const div = document.createElement("div");
    div.classList.add("message");

    if (sender === "user") div.classList.add("user-message");
    else div.classList.add("bot-message");

    div.textContent = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
}
