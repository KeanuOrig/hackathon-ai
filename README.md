# hackathon-ai
# Introduction
Decoupled architecture, Frontend(Vue) and Backend(Laravel)

# Instructions
1. Open separate terminals for backend and frontend.

# Frontend
1. npm install
2. npm run dev
3. Access app at http://localhost:9000/

# Backend
1. Copy env.example to create .env
2. Add your google keys
  GEMINI_API_KEY=
  GOOGLE_CLIENT_ID=
  GOOGLE_REDIRECT_URI=
  GOOGLE_CLIENT_SECRET=
3. add your sevice-key.json at storage/keys/gcp
4. Create mysql DB_DATABASE=gemini_ai
5. composer install
6. php artisan migrate
7. php artisan db:seed
8. php artisan serve --port=8000
   


