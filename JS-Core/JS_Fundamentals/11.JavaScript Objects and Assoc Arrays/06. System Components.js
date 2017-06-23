function systemSorter(dataArr) {
  let systems = new Map;
  for (let row of dataArr) {
    let [systemName, componentName, subcomponentName] = row.split(/\s\|\s/g);
    if (!systems.has(systemName)) {
      systems.set(systemName, new Map);
    }
    let currentSystem = systems.get(systemName);
    if (!currentSystem.has(componentName)) {
      currentSystem.set(componentName,[])
    }
    currentSystem.get(componentName).push(subcomponentName)

  }
  for (let [system,components] of [...systems].sort(sortSystems)) {
    console.log(system);
    for (let [component, subcomponents] of [...components].sort((a,b) => a[1].length < b[1].length ? 1 : -1)) {
      console.log(`|||${component}`);
      for (let subcomponent of subcomponents) {
        console.log(`||||||${subcomponent}`)
      }
    }
  }

  function sortSystems(a,b) {
    if (a[1].size > b[1].size) {
      return -1;
    } else if (a[1].size < b[1].size) {
      return 1;
    } else {
      if (a[0] > b[0]) {
        return 1;
      } else if (a[0] < b[0]) {
        return -1;
      } else {
        return 0;
      }
    }
  }
}

systemSorter([
  'SULS | Main Site | Home Page',
  'SULS | Main Site | Login Page',
  'SULS | Main Site | Register Page',
  'SULS | Judge Site | Login Page',
  'SULS | Judge Site | Submittion Page',
  'Lambda | CoreA | A23',
  'SULS | Digital Site | Login Page',
  'Lambda | CoreB | B24',
  'Lambda | CoreA | A24',
  'Lambda | CoreA | A25',
  'Lambda | CoreC | C4',
  'Indice | Session | Default Storage',
  'Indice | Session | Default Security',


]);