const mongoose = require('mongoose')
mongoose.Promise = global.Promise

const instanodeDb = require('./instanode-db')
// WARNING! instanode-db.js USES ASYNC/AWAIT WHICH IS AVAILABLE ONLY ON NODEJS v7.9.0 AND ABOVE.

mongoose.connect('mongodb://localhost:27017/instanode-database').then(() => {
  console.log('Connected!')
}).catch((error) => {
  console.log('Error connecting to mongodb')
  console.error(error)
})

// instanodeDb.saveImage({
//   url: 'https://i.ytimg.com/vi/tntOCGkgt98/maxresdefault.jpg',
//   description: 'such cat much wow',
//   tags: ['cat', 'kitty', 'cute', 'catstagram', 'nakenovkotkata']
// })

// instanodeDb.findByTag('cat')

// instanodeDb.filter({
//   after: 'YOUR DATE IN THIS FORMAT => 2017-05-30T08:39:49.426Z',
//   before: 'YOUR DATE IN THIS FORMAT => 2017-05-30T08:42:47.628Z',
//   results: 100
// })

