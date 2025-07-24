import streamlit as st
import pandas as pd
import mysql.connector
from prophet import Prophet
import plotly.express as px

# Database connection
db_config = {
    'host': 'sql12.freesqldatabase.com',
    'user': 'sql12791553',
    'password': 'B9Sva3lRQs',
    'database': 'sql12791553',
    'port': 3306
}

def fetch_sales():
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor(dictionary=True)
    cursor.execute("SELECT created_at, amount FROM sales_data")
    rows = cursor.fetchall()
    cursor.close()
    conn.close()
    return pd.DataFrame(rows)

def fetch_invoices(vendor=None):
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor(dictionary=True)
    query = "SELECT * FROM invoices"
    if vendor:
        query += " WHERE vendor_name = %s"
        cursor.execute(query, (vendor,))
    else:
        cursor.execute(query)
    rows = cursor.fetchall()
    cursor.close()
    conn.close()
    return pd.DataFrame(rows)

def predict_sales():
    df = fetch_sales()
    df.rename(columns={"created_at": "ds", "amount": "y"}, inplace=True)
    model = Prophet()
    model.fit(df)
    future = model.make_future_dataframe(periods=60)
    forecast = model.predict(future)
    return forecast

# Streamlit UI
st.set_page_config(page_title="AI Sales Chatbot", layout="centered")

st.title("📊 Steel Authority AI Assistant")

prompt = st.text_input("Ask me something (e.g., 'show sales', 'predict sales', 'invoice of aakhya'):")

if prompt:
    prompt_lower = prompt.lower()

    if "predict" in prompt_lower:
        st.info("Predicting future sales...")
        forecast = predict_sales()
        fig = px.line(forecast, x="ds", y="yhat", title="Sales Forecast")
        st.plotly_chart(fig)

    elif "sales" in prompt_lower:
        st.info("Showing past sales data...")
        sales = fetch_sales()
        st.dataframe(sales.tail(10))

    elif "invoice" in prompt_lower:
        vendor = None
        if "aakhya" in prompt_lower:
            vendor = "aakhya"
        elif "hello" in prompt_lower:
            vendor = "hello"
        invoices = fetch_invoices(vendor)
        if invoices.empty:
            st.warning("No invoices found.")
        else:
            st.dataframe(invoices)

    else:
        st.warning("Sorry, I didn't understand. Try asking about sales or invoices.")
