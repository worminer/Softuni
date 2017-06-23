const Image = require('./image.model')
const Tag = require('./tag.model')

module.exports = {
  async saveImage (imageObj) {
    const tempTags = imageObj.tags
    delete imageObj.tags

    let createdImage = await Image.create(imageObj)
    for (let tag of tempTags) {
      let updatedTag = await Tag.findOneAndUpdate(
        { name: tag },
        { $addToSet: { images: createdImage._id } },
        { upsert: true, new: true })
      createdImage.tags.push(updatedTag._id)
    }
    await createdImage.save()
    console.log('Created!')
  },
  async findByTag (tagName) {
    let retrievedTags = await Tag.findOne({ name: tagName })
      .populate('images', '', null, { sort: { 'creationDate': -1 } })
    console.log(retrievedTags.toObject().images)
    return retrievedTags.images
  },
  async filter (inputObj) {
    let retrievedImages = await Image
      .find({ $and: [{ creationDate: { $lt: inputObj.before } }, { creationDate: { $gt: inputObj.after } }] })
      .limit(inputObj.results)
      .populate('tags', 'name')
    let imgsToReturn = retrievedImages.map(img => img.toObject())
    console.dir(imgsToReturn)
    return imgsToReturn
  }
}
