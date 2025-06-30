<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$suggestions = [
    "acne" => [
        "en" => "Use topical retinoids and keep skin clean. Consult dermatologist for antibiotics.",
        "ta" => "மேல்மட்ட ரெடினாய்டுகளை பயன்படுத்தி, தோலை சுத்தமாக வைத்துக்கொள்ளவும். சவர்க்காரரிடம் ஆலோசனை பெறவும்.",
        "fr" => "Utilisez des rétinoïdes topiques et gardez la peau propre. Consultez un dermatologue.",
        "ja" => "外用レチノイドを使用し、肌を清潔に保ちます。皮膚科医に相談してください。",
        "hi" => "टोपिकल रेटिनॉइड्स का उपयोग करें और त्वचा को साफ रखें। त्वचा विशेषज्ञ से सलाह लें।",
        "ml" => "ടോപിക്കല്‍ റെറ്റിനോയ്ഡുകള്‍ ഉപയോഗിക്കുകയും ചര്‍മ്മം ശുചിയാക്കി സൂക്ഷിക്കുകയും ചെയ്യുക. ഡെര്‍മറ്റോളജിസ്റ്റുമായി ബന്ധപ്പെടുക.",
        "te" => "టాపికల్ రెటినాయిడ్స్‌ను ఉపయోగించి చర్మాన్ని శుభ్రంగా ఉంచండి. డెర్మటాలజిస్ట్‌ను సంప్రదించండి.",
        "ur" => "ٹاپیکل ریٹینوئڈز کا استعمال کریں اور جلد کو صاف رکھیں۔ ماہر امراض جلد سے مشورہ کریں۔",
        "kn" => "ಟಾಪಿಕಲ್ ರೆಟಿನಾಯ್ಡ್ಗಳನ್ನು ಬಳಸಿ, ಚರ್ಮವನ್ನು ಸ್ವಚ್ಛವಾಗಿಡಿ. ಚರ್ಮ ತಜ್ಞರನ್ನು ಸಂಪರ್ಕಿಸಿ."
    ],
    "eczema" => [
        "en" => "Use moisturizing creams and avoid irritants. Steroid creams may help.",
        "ta" => "இரப்பமூட்டும் கிரீம்கள் பயன்படுத்தவும், உலர்வான பொருட்கள் தவிர்க்கவும். ஸ்டீராய்டு கிரீம்கள் உதவக்கூடும்.",
        "fr" => "Utilisez des crèmes hydratantes et évitez les irritants. Les crèmes stéroïdes peuvent aider.",
        "ja" => "保湿クリームを使用し、刺激物を避けてください。ステロイドクリームが効果的です。",
        "hi" => "मॉइस्चराइजिंग क्रीम का उपयोग करें और उत्तेजक से बचें। स्टेरॉयड क्रीम मदद कर सकती हैं।",
        "ml" => "മോയ്‌സ്‌ചറൈസിംഗ് ക്രീമുകൾ ഉപയോഗിക്കുകയും раздражകങ്ങൾ ഒഴിവാക്കുകയും ചെയ്യുക. സ്റ്റെറോയിഡ് ക്രീമുകൾ സഹായകമായേക്കാം.",
        "te" => "తేమను ఇస్తున్న క్రీములను ఉపయోగించి, అరిటెంట్లను నివారించండి. స్టెరాయిడ్ క్రీములు సహాయపడవచ్చు.",
        "ur" => "موئسچرائزنگ کریمز کا استعمال کریں اور خراش دینے والی چیزوں سے پرہیز کریں۔ سٹیرائیڈ کریمز مددگار ہو سکتی ہیں۔",
        "kn" => "ಒದ್ದೆಗೊಳಿಸುವ ಕ್ರೀಮ್‌ಗಳನ್ನು ಬಳಸಿ, ರಾಸಾಯನಿಕಗಳಿಂದ ದೂರಿರಿ. ಸ್ಟೆರಾಯ್ಡ್ ಕ್ರೀಮ್‌ಗಳು ಸಹಾಯ ಮಾಡಬಹುದು."
    ],
    "psoriasis" => [
        "en" => "Use medicated creams, UV therapy, and systemic treatments if severe.",
        "ta" => "மருந்து உள்ள கிரீம்கள், UV சிகிச்சை மற்றும் கடுமையானால் முறைப்படுத்திய சிகிச்சைகள் பயன்படுத்தவும்.",
        "fr" => "Utilisez des crèmes médicinales, la thérapie UV et des traitements systémiques si nécessaire.",
        "ja" => "薬用クリーム、紫外線治療、重度の場合は全身療法を使用します。",
        "hi" => "दवाओं की क्रीम, UV थेरेपी और गंभीर मामलों में प्रणालीगत उपचार का उपयोग करें।",
        "ml" => "മരുന്നുള്ള ക്രീമുകൾ, UV ചികിത്സ, ഗുരുതരമായാൽ സിസ്റ്റമാറ്റിക് ചികിത്സ ഉപയോഗിക്കുക.",
        "te" => "మెడికేటెడ్ క్రీములు, UV థెరపీ మరియు తీవ్రమైతే సిస్టమిక్ చికిత్సలను ఉపయోగించండి.",
        "ur" => "دوائیوں والے کریمز، یووی تھراپی، اور شدید صورت میں نظامی علاج کا استعمال کریں۔",
        "kn" => "ಔಷಧ ಕ್ರೀಮ್‌ಗಳು, ಯುವಿ ಚಿಕಿತ್ಸೆ ಮತ್ತು ತೀವ್ರವಾದರೆ ವ್ಯವಸ್ಥಿತ ಚಿಕಿತ್ಸೆಯನ್ನು ಬಳಸಿ."
    ],

    // ✅ Add more diseases here
    "ringworm" => [
        "en" => "Use antifungal cream and keep area dry. Avoid sharing personal items.",
        "ta" => "ஊட்டச்சத்து எதிர்ப்பு கிரீம்களை பயன்படுத்தவும் மற்றும் பகுதியை உலர வைக்கவும்.",
        "fr" => "Utilisez une crème antifongique et gardez la zone sèche. Ne partagez pas d'objets personnels.",
        "ja" => "抗真菌クリームを使用し、患部を乾燥させてください。私物の共有を避けてください。",
        "hi" => "एंटीफंगल क्रीम का उपयोग करें और क्षेत्र को सूखा रखें। व्यक्तिगत वस्तुएं साझा न करें।",
        "ml" => "ആന്റിഫംഗൽ ക്രീം ഉപയോഗിച്ച് ഭാഗം ഉണക്കം നിലനിർത്തുക. വ്യക്തിഗത വസ്തുക്കൾ പങ്കിടരുത്.",
        "te" => "యాంటీఫంగల్ క్రీమ్‌ను ఉపయోగించి ఆ ప్రాంతాన్ని పొడిగా ఉంచండి. వ్యక్తిగత వస్తువులను పంచుకోకుండా ఉండండి.",
        "ur" => "اینٹی فنگل کریم استعمال کریں اور متاثرہ جگہ کو خشک رکھیں۔ ذاتی اشیاء کا تبادلہ نہ کریں۔",
        "kn" => "ಊತಿದ ಸೋಂಕು ತಡೆಗಟ್ಟುವ ಕ್ರೀಮ್ ಬಳಸಿ, ಪ್ರದೇಶವನ್ನು ಒಣಗಿಟ್ಟುಕೊಳ್ಳಿ. ವೈಯಕ್ತಿಕ ವಸ್ತುಗಳನ್ನು ಹಂಚಿಕೊಳ್ಳಬೇಡಿ."
    ],

    "melanoma" => [
        "en" => "Seek immediate medical advice. Early treatment is crucial.",
        "ta" => "உடனடி மருத்துவ ஆலோசனையை பெறுங்கள். ஆரம்ப சிகிச்சை முக்கியம்.",
        "fr" => "Consultez immédiatement un médecin. Le traitement précoce est essentiel.",
        "ja" => "すぐに医師の診察を受けてください。早期治療が重要です。",
        "hi" => "तुरंत चिकित्सा सलाह लें। प्रारंभिक उपचार आवश्यक है।",
        "ml" => "ഉടന്‍ ഡോക്ടറുടെ ഉപദേശമെടുക്കുക. പ്രാരംഭ ചികിത്സ അത്യാവശ്യമാണ്.",
        "te" => "తక్షణం వైద్య సలహా తీసుకోండి. ప్రారంభ చికిత్స కీలకం.",
        "ur" => "فوری طور پر طبی مشورہ لیں۔ ابتدائی علاج بہت ضروری ہے۔",
        "kn" => "ತಕ್ಷಣ ವೈದ್ಯಕೀಯ ಸಲಹೆ ಪಡೆಯಿರಿ. ಆರಂಭಿಕ ಚಿಕಿತ್ಸೆ ಅಗತ್ಯವಿದೆ."
    ],

    // 🔁 Add more diseases following the same format
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $command = escapeshellcmd("python predict.py " . escapeshellarg($target_file));
        $output = shell_exec($command);

        $result = explode('|', trim($output));
        $disease = $result[0] ?? 'Unknown';
        $confidence = isset($result[1]) ? floatval($result[1]) : 0;

        $disease_key = strtolower($disease);
        $suggestion_text = $suggestions[$disease_key]['en'] ?? "Please consult a dermatologist for advice.";
        $image_url = $target_file;
    } else {
        $error = "Failed to upload image.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Skin Disease Detection</title>
<style>
  /* Reset & base */
  * {
    box-sizing: border-box;
  }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #8EC5FC 0%, #E0C3FC 100%);
    margin: 0;
    padding: 10px;
    color: #333;
  }
  .container {
    max-width: 600px;
    background: #fff;
    border-radius: 15px;
    padding: 30px 40px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    margin: 30px auto;
  }
  h1#title {
    text-align: center;
    font-size: 2.5rem;
    color: #5B2C6F;
    margin-bottom: 25px;
    font-weight: 700;
    letter-spacing: 1px;
  }
  form {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 30px;
  }
  input[type="file"] {
    padding: 10px;
    border: 2px dashed #8EC5FC;
    border-radius: 10px;
    cursor: pointer;
    transition: border-color 0.3s ease;
    flex: 1;
  }
  input[type="file"]:hover {
    border-color: #5B2C6F;
  }
  button#uploadBtn {
    background: #5B2C6F;
    color: white;
    border: none;
    padding: 12px 25px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.3s ease;
    box-shadow: 0 8px 15px rgba(91, 44, 111, 0.3);
  }
  button#uploadBtn:hover {
    background: #7D3C98;
    box-shadow: 0 12px 20px rgba(125, 60, 152, 0.5);
  }
  .result {
    background: #F7F1FF;
    border: 2px solid #A569BD;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 20px rgba(165, 105, 189, 0.2);
  }
  .result h2#resultTitle {
    color: #6C3483;
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 1.7rem;
  }
  .result p {
    font-size: 1.1rem;
    margin: 10px 0;
  }
  .result p strong {
    color: #5B2C6F;
  }
  .result img {
    display: block;
    max-width: 100%;
    margin: 25px auto 0 auto;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(91, 44, 111, 0.3);
  }
  .language-select {
    margin-top: 30px;
    text-align: center;
  }
  .language-select label {
    font-weight: 600;
    font-size: 1.1rem;
    margin-right: 12px;
    color: #5B2C6F;
  }
  #language {
    padding: 8px 14px;
    font-size: 1rem;
    border-radius: 8px;
    border: 2px solid #8EC5FC;
    cursor: pointer;
    transition: border-color 0.3s ease;
  }
  #language:hover {
    border-color: #5B2C6F;
  }
  /* Error message style */
  .result[style*="background-color:#fed7d7"] p {
    color: #b30000;
    font-weight: 700;
  }

  /* Responsive */
  @media (max-width: 480px) {
    .container {
      padding: 20px;
      margin: 15px;
    }
    h1#title {
      font-size: 2rem;
    }
    form {
      flex-direction: column;
    }
    input[type="file"], button#uploadBtn {
      width: 100%;
      box-sizing: border-box;
    }
    button#uploadBtn {
      margin-top: 15px;
    }
  }
</style>
</head>
<body>
  <div class="container">
    <h1 id="title">Skin Disease Detection</h1>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="image" accept="image/*" required id="imageInput" />
      <button type="submit" id="uploadBtn">Predict Disease</button>
    </form>

    <?php if(!empty($error)): ?>
      <div class="result" style="background-color:#fed7d7; border-color:#f56565;">
        <p><strong>Error:</strong> <?= htmlspecialchars($error) ?></p>
      </div>
    <?php endif; ?>

    <?php if(!empty($disease)): ?>
    <div class="result" id="resultBox">
      <h2 id="resultTitle">Prediction Result:</h2>
      <p><strong id="diseaseLabel">Disease Detected:</strong> 
         <span id="diseaseName" data-disease-key="<?= htmlspecialchars($disease_key) ?>">
           <?= htmlspecialchars($disease) ?>
         </span>
      </p>
      <p><strong id="confidenceLabel">Confidence:</strong> <span id="confidenceVal"><?= number_format($confidence, 2) ?>%</span></p>
      <p><strong id="suggestionLabel">Suggestion:</strong> <span id="suggestionText"><?= htmlspecialchars($suggestion_text) ?></span></p>
      <img src="<?= htmlspecialchars($image_url) ?>" alt="Uploaded Skin Image" />
    </div>
    <?php endif; ?>

    <div class="language-select">
      <label for="language">🌐 Language: </label>
      <select id="language">
        <option value="en" selected>English</option>
        <option value="es">Español</option>
        <option value="fr">Français</option>
        <option value="hi">हिंदी</option>
        <option value="ta">தமிழ்</option>
<option value="te">తెలుగు</option>
<option value="kn">ಕನ್ನಡ</option>
<option value="ml">മലയാളം</option>
<option value="ur">اردو</option>
<option value="ja">日本語</option>

      </select>
    </div>
  </div>

<script>
const translations = {
  en: {
    title: "Skin Disease Detection",
    uploadBtn: "Predict Disease",
    resultTitle: "Prediction Result:",
    diseaseLabel: "Disease Detected:",
    confidenceLabel: "Confidence:",
    suggestionLabel: "Suggestion:",
    languageLabel: "🌐 Language:",
    diseases: {
      acne: "Acne",
      eczema: "Eczema",
      psoriasis: "Psoriasis"
    },
    suggestions: {
      acne: "Use topical retinoids and keep skin clean. Consult dermatologist for antibiotics.",
      eczema: "Use moisturizing creams and avoid irritants. Steroid creams may help.",
      psoriasis: "Use medicated creams, UV therapy, and systemic treatments if severe."
    }
  },
  es: {
    title: "Detección de Enfermedades de la Piel",
    uploadBtn: "Predecir Enfermedad",
    resultTitle: "Resultado de la Predicción:",
    diseaseLabel: "Enfermedad Detectada:",
    confidenceLabel: "Confianza:",
    suggestionLabel: "Sugerencia:",
    languageLabel: "🌐 Idioma:",
    diseases: {
      acne: "Acné",
      eczema: "Eccema",
      psoriasis: "Psoriasis"
    },
    suggestions: {
      acne: "Use retinoides tópicos y mantenga la piel limpia. Consulte al dermatólogo para antibióticos.",
      eczema: "Use cremas hidratantes y evite irritantes. Las cremas con esteroides pueden ayudar.",
      psoriasis: "Use cremas medicadas, terapia UV y tratamientos sistémicos si es grave."
    }
  },
  fr: {
    title: "Détection des Maladies de la Peau",
    uploadBtn: "Prédire la Maladie",
    resultTitle: "Résultat de la Prédiction :",
    diseaseLabel: "Maladie Détectée :",
    confidenceLabel: "Confiance :",
    suggestionLabel: "Suggestion :",
    languageLabel: "🌐 Langue :",
    diseases: {
      acne: "Acné",
      eczema: "Eczéma",
      psoriasis: "Psoriasis"
    },
    suggestions: {
      acne: "Utilisez des rétinoïdes topiques et gardez la peau propre. Consultez un dermatologue.",
      eczema: "Utilisez des crèmes hydratantes et évitez les irritants. Les crèmes stéroïdes peuvent aider.",
      psoriasis: "Utilisez des crèmes médicinales, la thérapie UV et des traitements systémiques si nécessaire."
    }
  },
  hi: {
    title: "त्वचा रोग पहचान",
    uploadBtn: "रोग की भविष्यवाणी करें",
    resultTitle: "पूर्वानुमान परिणाम:",
    diseaseLabel: "पता चला रोग:",
    confidenceLabel: "विश्वसनीयता:",
    suggestionLabel: "सुझाव:",
    languageLabel: "🌐 भाषा:",
    diseases: {
      acne: "मुँहासे",
      eczema: "एग्जिमा",
      psoriasis: "सोरायसिस"
    },
    suggestions: {
      acne: "टोपिकल रेटिनॉइड्स का उपयोग करें और त्वचा को साफ रखें। त्वचा विशेषज्ञ से सलाह लें।",
      eczema: "मॉइस्चराइजिंग क्रीम का उपयोग करें और उत्तेजक से बचें। स्टेरॉयड क्रीम मदद कर सकती हैं।",
      psoriasis: "दवाओं की क्रीम, UV थेरेपी और गंभीर मामलों में प्रणालीगत उपचार का उपयोग करें।"
    }
  },
  tamil: {
  title: "தோல் நோய் கண்டறிதல்",
  uploadBtn: "நோயை கணிக்கவும்",
  resultTitle: "முன்னறிவிப்பு முடிவு:",
  diseaseLabel: "கண்டறியப்பட்ட நோய்:",
  confidenceLabel: "நம்பிக்கை:",
  suggestionLabel: "பரிந்துரை:",
  languageLabel: "🌐 மொழி:",
  diseases: {
    melanoma: "மெலனோமா",
    vitiligo: "விடுபட்டு வரும் வெண்மை",
    rosacea: "ரோசாசியா",
    ringworm: "வட்ட வடிவ பூஞ்சை",
    dermatitis: "தோல் அழற்சி"
  },
  suggestions: {
    melanoma: "விரைவாக ஒரு தோல் மருத்துவர்களை பார்வையிடுங்கள். சிகிச்சை அவசியம்.",
    vitiligo: "தோல் நிறத்தை மீட்டெடுக்க சிகிச்சைகள் மற்றும் கிரீம்கள் உதவும்.",
    rosacea: "முகத்தை சுத்தமாக வைத்திருங்கள், மசாலா உணவுகளை தவிர்க்கவும்.",
    ringworm: "பூஞ்சை எதிர்ப்பு கிரீம்கள் பயன்படுத்தவும். சுகாதாரத்தை பேணவும்.",
    dermatitis: "குடைந்த குளிர்க் கிரீம்கள் மற்றும் ஓரளவு ஸ்டீராய்டு கிரீம்கள் உதவலாம்."
  }
},

telugu: {
  title: "చర్మ వ్యాధి గుర్తింపు",
  uploadBtn: "రోగాన్ని అంచనా వేయండి",
  resultTitle: "ఫలితాలు:",
  diseaseLabel: "గుర్తించబడిన వ్యాధి:",
  confidenceLabel: "ఆత్మవిశ్వాసం:",
  suggestionLabel: "సూచన:",
  languageLabel: "🌐 భాష:",
  diseases: {
    melanoma: "మెలెనోమా",
    vitiligo: "విటిలిగో",
    rosacea: "రోసేసియా",
    ringworm: "రింగ్‌వర్మ్",
    dermatitis: "డర్మటైటిస్"
  },
  suggestions: {
    melanoma: "డెర్మటాలజిస్ట్‌ను వెంటనే సంప్రదించండి. ఇది తీవ్రమైనది.",
    vitiligo: "చర్మం రంగును తిరిగి పొందే చికిత్సలు ఉండవచ్చు.",
    rosacea: "ముఖాన్ని శుభ్రంగా ఉంచండి మరియు వేడి ఆహారం నివారించండి.",
    ringworm: "యాంటీఫంగల్ క్రీమ్‌లు ఉపయోగించండి.",
    dermatitis: "మాయిశ్చరైజర్ మరియు స్టెరాయిడ్ క్రీమ్‌లు ఉపశమనం ఇస్తాయి."
  }
},

kannada: {
  title: "ಚರ್ಮ ರೋಗ ಪತ್ತೆ",
  uploadBtn: "ರೋಗದ ಊಹೆಮಾಡಿ",
  resultTitle: "ಪರಿಣಾಮ:",
  diseaseLabel: "ಹುಡಿದ ರೋಗ:",
  confidenceLabel: "ಆತ್ಮವಿಶ್ವಾಸ:",
  suggestionLabel: "ಸಲಹೆ:",
  languageLabel: "🌐 ಭಾಷೆ:",
  diseases: {
    melanoma: "ಮೆಲನವೋಮಾ",
    vitiligo: "ವಿಟಿಲಿಗೋ",
    rosacea: "ರೋಸೆಶಿಯಾ",
    ringworm: "ರಿಂಗ್‌ವರ್ಮ್",
    dermatitis: "ಡರ್ಮಟೈಟಿಸ್"
  },
  suggestions: {
    melanoma: "ಡರ್ಮಟೋಲಾಜಿಸ್ಟ್ ಅನ್ನು ತಕ್ಷಣ ಸಂಪರ್ಕಿಸಿ.",
    vitiligo: "ಚರ್ಮದ ಬಣ್ಣ ಮರುಸ್ಥಾಪನೆಗೆ ಚಿಕಿತ್ಸೆಗಳು ಲಭ್ಯವಿವೆ.",
    rosacea: "ಚರ್ಮವನ್ನು ಶುದ್ಧವಾಗಿ ಇಡಿ, ಉಗ್ರ ಆಹಾರದಿಂದ ದೂರವಿರಿ.",
    ringworm: "ಯಾಂಟಿಫಂಗಲ್ ಕ್ರೀಮ್ ಬಳಸಿರಿ.",
    dermatitis: "ನಿವಾರಕ ಕ್ರೀಮ್ ಮತ್ತು ಸ್ಟಿರಾಯ್ಡ್ ಸಹಾಯ ಮಾಡಬಹುದು."
  }
},

malayalam: {
  title: "ത്വക് രോഗ നിരീക്ഷണം",
  uploadBtn: "രോഗം പ്രവചിക്കുക",
  resultTitle: "ഫലം:",
  diseaseLabel: "കണ്ടെത്തിയ രോഗം:",
  confidenceLabel: "ആശ്വാസം:",
  suggestionLabel: "ഉപരിപഠനം:",
  languageLabel: "🌐 ഭാഷ:",
  diseases: {
    melanoma: "മെലനോമ",
    vitiligo: "വിറ്റിലിഗോ",
    rosacea: "റോസേഷ്യ",
    ringworm: "റിംഗ്‌വോം",
    dermatitis: "ഡെർമറ്റൈറ്റിസ്"
  },
  suggestions: {
    melanoma: "വേഗം ഡെർമറ്റോളജിസ്റ്റിനെ സമീപിക്കുക.",
    vitiligo: "ത്വക് നിറം പുനഃസ്ഥാപിക്കാൻ ചികിത്സ ലഭ്യമാണ്.",
    rosacea: "മുഖം വൃത്തിയാക്കുക, മസാലാ ഭക്ഷണം ഒഴിവാക്കുക.",
    ringworm: "ആന്റിഫംഗൽ ക്രീം ഉപയോഗിക്കുക.",
    dermatitis: "തെളിഞ്ഞ ക്രീം, സ്റ്റിറോയ്ഡ് ഉപയോഗം ഉതകും."
  }
},

urdu: {
  title: "جلدی بیماری کی شناخت",
  uploadBtn: "بیماری کی پیشن گوئی کریں",
  resultTitle: "نتائج:",
  diseaseLabel: "پتہ چلنے والی بیماری:",
  confidenceLabel: "اعتماد:",
  suggestionLabel: "مشورہ:",
  languageLabel: "🌐 زبان:",
  diseases: {
    melanoma: "میلانوم",
    vitiligo: "وٹیلگو",
    rosacea: "روسیشیا",
    ringworm: "رنگ ورم",
    dermatitis: "ڈرمٹائٹس"
  },
  suggestions: {
    melanoma: "فوری طور پر ماہر جلد سے رابطہ کریں۔",
    vitiligo: "جلد کا رنگ واپس لانے کے لیے علاج موجود ہیں۔",
    rosacea: "چہرہ صاف رکھیں، مصالحہ دار کھانے سے پرہیز کریں۔",
    ringworm: "اینٹی فنگل کریم استعمال کریں۔",
    dermatitis: "موئسچرائزر اور سٹیرائڈ کریم مددگار ہوسکتی ہیں۔"
  }
},

japanese: {
  title: "皮膚病の検出",
  uploadBtn: "病気を予測する",
  resultTitle: "予測結果：",
  diseaseLabel: "検出された病気：",
  confidenceLabel: "信頼度：",
  suggestionLabel: "提案：",
  languageLabel: "🌐 言語：",
  diseases: {
    melanoma: "メラノーマ",
    vitiligo: "白斑",
    rosacea: "酒さ",
    ringworm: "水虫",
    dermatitis: "皮膚炎"
  },
  suggestions: {
    melanoma: "すぐに皮膚科医に相談してください。",
    vitiligo: "色素を戻す治療があります。",
    rosacea: "顔を清潔に保ち、辛い食べ物を避けてください。",
    ringworm: "抗真菌クリームを使用してください。",
    dermatitis: "保湿剤やステロイドクリームが有効です。"
  }
}

};

const languageSelect = document.getElementById('language');
languageSelect.addEventListener('change', (e) => {
  const lang = e.target.value;
  const trans = translations[lang];

  // Translate static text
  document.getElementById('title').textContent = trans.title;
  document.getElementById('uploadBtn').textContent = trans.uploadBtn;
  document.getElementById('resultTitle').textContent = trans.resultTitle;
  document.getElementById('diseaseLabel').textContent = trans.diseaseLabel;
  document.getElementById('confidenceLabel').textContent = trans.confidenceLabel;
  document.getElementById('suggestionLabel').textContent = trans.suggestionLabel;
  document.querySelector('label[for="language"]').textContent = trans.languageLabel;

  // Translate disease name and suggestion if result shown
  const diseaseNameSpan = document.getElementById('diseaseName');
  if (diseaseNameSpan) {
    const diseaseKey = diseaseNameSpan.dataset.diseaseKey;
    const localizedDisease = trans.diseases[diseaseKey] || diseaseNameSpan.textContent;
    const localizedSuggestion = trans.suggestions[diseaseKey] || document.getElementById('suggestionText').textContent;
    diseaseNameSpan.textContent = localizedDisease;
    document.getElementById('suggestionText').textContent = localizedSuggestion;
  }
});
</script>
</body>
</html>
