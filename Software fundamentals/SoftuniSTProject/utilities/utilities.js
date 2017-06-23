// makes array from string containing comma with random spaces
module.exports.splitByComma = (inputString) =>{
    return inputString.replace(/(\s+,\s+)|(,\s+)|(\s+,)/g,',').split(',').filter(arrPart => {
        //console.log(arrPart)
        return arrPart
    });
};

module.exports.getFieldToArr = (mongooseObj,fieldName) => {
    if(typeof mongooseObj === 'undefined'){
        mongooseObj = {};
        console.log("utils getFieldToArr: mongooseObj is undefined");
    }
    if(typeof fieldName === 'undefined'){
        fieldName = '';
        console.log("utils getFieldToArr: fieldName is undefined");
    }
    let arr = [];
    mongooseObj.filter(data => {
        arr.push(data[fieldName]);
    });
    return arr;
};

module.exports.removeArrFromArr = (arrMain,arrToRemove) => {
    return arrMain.filter(x => arrToRemove.indexOf(x) < 0 );
};

// specialised stuff

module.exports.getGenresNotInDB = (genresArr, genresDBObj) => {
    let genresInDBArr = this.getFieldToArr(genresDBObj,'name');

    return this.removeArrFromArr(genresArr,genresInDBArr)
};

module.exports.arrayIfNeeded = (data)=> {
    //console.log('Data Type:' + typeof data + ' of data ' + data);

    if(typeof data === 'undefined'){
        console.log("Data is Undefined");
        return undefined;
    }

    if(typeof data === 'string'){
        let dataArr = [];
        dataArr.push(data);
        return dataArr;
    }

    if(typeof data === 'object'){
        return data;
    }




}

module.exports.dotdotdot = (str,len) => {
    if(typeof str === 'undefined'){
        str = '';
        console.log("utils dotdotdot: dotdotdot -> str is undefined");
    }
    if(typeof len === 'undefined'){
        len = 10;
        console.log("utils dotdotdot: dotdotdot -> len is undefined");
    }
    if(len <=10){
        len = 10
    }
    //console.log("handlebar helper: dotdotdot -> len is " + len);
    if (str.length > len)
        return str.substring(0,len) + '...';
    return str;
}

module.exports.limitCharsLenInMongooseObj = (mongooseObj,tableName,len)=>{
    if(typeof mongooseObj === 'undefined'){
        mongooseObj = {};
        console.log("limitCharsLenInMongooseObj: mongooseObj -> is undefined ");
    }
    if(typeof tableName === 'undefined'){
        tableName = '';
        console.log("limitCharsLenInMongooseObj: tableName -> is undefined");
    }
    if(typeof len === 'undefined'){
        len = 0;
        console.log("limitCharsLenInMongooseObj: len -> is undefined");
    }

    for (let i = 0; i < mongooseObj.length; i++) {
        mongooseObj[i][tableName] = this.dotdotdot(mongooseObj[i][tableName],len);
    }
    return mongooseObj;
}
module.exports.randomIntFromInterval = (min,max) =>
    {
        return Math.floor(Math.random()*(max-min+1)+min);
    }