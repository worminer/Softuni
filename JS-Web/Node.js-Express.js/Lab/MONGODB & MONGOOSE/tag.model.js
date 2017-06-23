const mongoose = require('mongoose')

const tagSchema = mongoose.Schema({
  name: {
    type: mongoose.Schema.Types.String,
    required: true
  },
  creationDate: {
    type: mongoose.Schema.Types.Date,
    required: true,
    default: new Date()
  },
  images: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Image' }]
})

module.exports = mongoose.model('Tag', tagSchema)
