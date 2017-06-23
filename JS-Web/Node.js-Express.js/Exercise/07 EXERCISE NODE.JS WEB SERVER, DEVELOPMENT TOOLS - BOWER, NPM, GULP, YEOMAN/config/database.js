// image data Storage
let imageDataStorage = [];

module.exports = {
  getAllImages () {
    return imageDataStorage
  },
  addNewImage (data) {
    imageDataStorage.push(data)
  },
  getImageItem (index) {
    return imageDataStorage[index]
  }
};
