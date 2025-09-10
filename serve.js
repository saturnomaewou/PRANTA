const express = require('express');
const multer  = require('multer');
const path = require('path');

const app = express();
const port = 3000;

// Configuração do Multer para onde salvar os arquivos
const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, 'uploads/')  // Pasta onde os arquivos serão salvos
  },
  filename: function (req, file, cb) {
    cb(null, file.fieldname + '-' + Date.now() + path.extname(file.originalname))
  }
})

const upload = multer({ storage: storage });

// Servir arquivos estáticos (como o HTML)
app.use(express.static('public')); // Assumindo que o HTML está em uma pasta chamada 'public'

// Rota para receber o arquivo
app.post('/upload', upload.single('pdf_file'), (req, res) => {
  if (!req.file) {
    return res.status(400).send('Nenhum arquivo foi enviado.');
  }

  console.log(req.file); // Informações sobre o arquivo

  res.send('Arquivo recebido com sucesso!');
});

app.listen(port, () => {
  console.log(`Servidor rodando em http://localhost:${port}`);
});
