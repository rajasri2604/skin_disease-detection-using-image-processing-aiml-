import sys
import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image

try:
    img_path = sys.argv[1]
    model = load_model("model/skin_model.h5")
    class_names = ['acne', 'eczema', 'Psoriasis']

    img = image.load_img(img_path, target_size=(150, 150))
    img_array = image.img_to_array(img) / 255.0
    img_array = np.expand_dims(img_array, axis=0)

    prediction = model.predict(img_array, verbose=0)[0]
    predicted_index = np.argmax(prediction)
    predicted_class = class_names[predicted_index]
    confidence = float(prediction[predicted_index]) * 100

    print(f"{predicted_class}|{confidence:.2f}")
except Exception as e:
    print("Error:", str(e))
