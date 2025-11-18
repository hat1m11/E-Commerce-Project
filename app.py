from flask import Flask, render_template

app = Flask(__name__)

@app.route('/')
def home():
    return render_template("index.html")


@app.route("/login")
def login():
    return render_template("login.html")

@app.route('/register')
def register():
    return render_template('register.html')

@app.route("/contact")
def contact():
    return render_template("contact.html")

@app.route("/products")
def products():
    return render_template("products.html")

@app.route("/basket")
def basket():
    return render_template("basket.html")

@app.route("/about")
def about():
    return render_template("about.html")

if __name__ == "__main__":
    app.run(debug=True)
