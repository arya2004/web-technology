curl -X POST http://0.0.0.0:3000/add-student \
     -H "Content-Type: application/json" \
     -d '{
           "name": "John Doe",
           "rollNumber": "21BCS001"
         }'
