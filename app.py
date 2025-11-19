from flask import Flask, render_template
app = Flask(__name__)

@app.route('/')
def home():
    return render_template("index.html")

    @app.route('/admin-login')
    def admin_login():
        return render_template("admin/admin_login.html")

        @app.route('/customer/login')
        def customer_login():
            return render_template("customer/customer_login.html")

        @app.route('/customer/signup')
        def customer_signup():
            return render_template("customer/customer_signup.html")

            @app.route('admin/signup')
            def admin_signup():
                return render_template("admin/admin_signup.html")

        

if __name__ == "__main__":
    app.run(debug=True)
