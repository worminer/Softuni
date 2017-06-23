function solve(arr) {
  let specialKey = arr.shift();
  for (let line of arr) {
    line = line.replace(/(?:(?:^| )([\w]+))\s+(([A-Z!#$%]{8,})+)( |$|\.|,)/gm, (match, gr1, gr2) => {
      if (specialKey.toLowerCase() !== gr1.toLowerCase()) {
        return match;
      }
      return match.replace(gr2, (match) => {
         return match
             .replace(/[!]/g, '1')
             .replace(/[%]/g, '2')
             .replace(/[#]/g, '3')
             .replace(/[$]/g, '4')
             .toLowerCase();
       })

    });
    console.log(line)
  }
}
solve([
  'specialKey',
  'In this text the specialKey HELLOWORLD! is correct, but',
  'the following specialKey $HelloWorl#d and spEcIaLKEy HOLLOWORLD1 are not, while',
  'SpeCIaLkeY   SOM%%ETH$IN and SPECIALKEY ##$$##$$ are!',
]);

solve([
  'miXedTestS',
  'This should be correct - mixedtests          ISCORRECTOK,',
  'not this one though remiXedTestS ITSWRONGKIDS',
  'as is this one mixedtestsos               TOTALL!WRONG',
  'Now on to the correct ones MIXEDTESTS  WHYSHOULDITFAIL or this MiXeDtEsTs OK!DOK!LOK!',
  'and here are some more',
  'mIXeDtEsTS JUS!%T#SO!!M$%%ST##!$FF',
  'MIXEDtests ITSF!%NERE#$LLY. mixedTESTS   ANOTHEROKONE',
  'this one\'s wrong tho mixedTest  WRONGTEST',
])