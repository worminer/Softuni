const mongoose = require('mongoose')

const imageSchema = mongoose.Schema({
  url: {
    type: mongoose.Schema.Types.String,
    required: true
  },
  creationDate: {
    type: mongoose.Schema.Types.Date,
    default: new Date(),
    required: true
  },
  description: {
    type: mongoose.Schema.Types.String,
    required: true
  },
  tags: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Tag' }]
})

module.exports = mongoose.model('Image', imageSchema)
