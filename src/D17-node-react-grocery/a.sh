# Clone / create project folder and enter it
mkdir grocery-shop && cd grocery-shop

# 1) Backend setup
mkdir backend && cd backend
npm init -y
npm install express sequelize mysql2 dotenv cors jsonwebtoken bcryptjs
# (you may add nodemon as dev dependency)
npm install --save-dev nodemon
cd ..

# 2) Frontend setup
npx create-react-app frontend
cd frontend
npm install axios react-router-dom bootstrap
cd ..

# 3) Bring up MySQL
docker-compose up -d

# 4) Run backend
cd backend
# populate .env from .env.example then
npm run dev   # assuming you add a dev script for nodemon

# 5) Run frontend
cd ../frontend
npm start
