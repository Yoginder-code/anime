from flask import Flask, request, jsonify, render_template
import pickle
import pandas as pd
import re

app = Flask(__name__)

# Load the recommender model and DataFrame
with open('recommender_model.pkl', 'rb') as model_file:
    loaded_model = pickle.load(model_file)

df = pd.read_pickle('food_data.pkl')

def recommend_top_food(name, c_type, veg_non):
    food_name_pattern = re.compile(re.escape(name), re.IGNORECASE)
    c_type_pattern = re.compile(re.escape(c_type), re.IGNORECASE)
    veg_non_pattern = re.compile(re.escape(veg_non), re.IGNORECASE)

    # Filter the DataFrame based on regex patterns
    filtered_df = df[df['Name'].str.contains(food_name_pattern) & 
                     df['C_Type'].str.contains(c_type_pattern) & 
                     df['Veg_Non'].str.contains(veg_non_pattern)]

    if filtered_df.empty:
        print("No matching food items found based on your preferences.")
        return recommend_top_5_based_on_ratings(df)

    user_id = 1  # Default user ID
    predictions = {}

    for food_id in filtered_df['Food_ID']:
        predicted_rating = loaded_model.predict(user_id, food_id).est
        predictions[food_id] = predicted_rating

    sorted_predictions = sorted(predictions.items(), key=lambda x: x[1], reverse=True)

    unique_foods = []
    for food_id, predicted_rating in sorted_predictions:
        food_item = filtered_df[filtered_df['Food_ID'] == food_id].iloc[0]
        unique_foods.append(food_item['Name'])

        if len(unique_foods) >= 5:
            break

    return [{"name": name.capitalize()} for name in unique_foods]

def recommend_top_5_based_on_ratings(df):
    avg_ratings = df.groupby(['Food_ID', 'Name', 'C_Type', 'Veg_Non'])['Rating'].mean().reset_index()
    top_rated_foods = avg_ratings.sort_values(by='Rating', ascending=False).head(5)
    
    return [{"name": row['Name'].capitalize()} for index, row in top_rated_foods.iterrows()]

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/menu')
def menu():
    return render_template('menu.html')

@app.route('/reservation')
def reservation():
    return render_template('reservation.html')

@app.route('/gallery')
def gallery():
    return render_template('gallery.html')

@app.route('/information')
def information():
    return render_template('information.html')

@app.route('/recommend', methods=['POST'])
def recommend():
    data = request.get_json()
    name = data.get('name', "")
    c_type = data.get('c_type', "")
    veg_non = data.get('veg_non', "")

    recommendations = recommend_top_food(name, c_type, veg_non)
    return jsonify(recommendations)

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=3000, debug=True)
