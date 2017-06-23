function distanceBetweenPoints(x1, y1, x2, y2) {
  let firstPoint = {x : x1, y : y1};
  let secondPoint = {x : x2, y : y2};

  console.log(
      Math.sqrt(
          Math.pow(firstPoint.x - secondPoint.x, 2) + Math.pow(firstPoint.y - secondPoint.y, 2)
      )
  );
}
distanceBetweenPoints(2, 4, 5, 0);
distanceBetweenPoints(2.34, 15.66, -13.55, -2.9985);