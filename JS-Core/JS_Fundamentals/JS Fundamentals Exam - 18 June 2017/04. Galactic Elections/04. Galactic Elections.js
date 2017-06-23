function vote(ballots) {
  let systems = new Map();
  let systemWinners = new Map();
  let totalVotes = 0;
  // sorting the data
  for (let ballot of ballots) {
    if (!systems.has(ballot.system)) {
      systems.set(ballot.system, new Map());
    }

    let cSystem = systems.get(ballot.system);

    if (!cSystem.has(ballot.candidate)) {
      cSystem.set(ballot.candidate, 0)
    }
    let cCandidateVotes = cSystem.get(ballot.candidate);

    cSystem.set(ballot.candidate, Number(cCandidateVotes) + Number(ballot.votes));
    totalVotes += ballot.votes;
  }

  for (let system of systems) {
    let systemVotes = 0;
    let winner = '';
    let currentWinnerVotes = 0;
    for (let [candidate,votes] of system[1]) {
      if (votes > currentWinnerVotes) {
        currentWinnerVotes = votes;
        winner = candidate;
      }
      systemVotes += votes;
    }

    systemWinners.set(system[0],new Map);
    systemWinners.get(system[0]).set(winner,systemVotes);
  }
  let winners = new Map;
  for (let [systemName, winner] of systemWinners) {

    let [winnerName, votes] = [...winner][0];
    if (!winners.has(winnerName)) {
      winners.set(winnerName, 0);
    }
    let cCandidate = winners.get(winnerName);
    winners.set(winnerName,cCandidate + votes);
  }
  let sortedWinners = [...winners].sort((a,b)=>{
    return a[1] > b[1]? -1: 1;
  });
  if (sortedWinners.length === 1) {
    console.log(`${sortedWinners[0][0]} wins with ${sortedWinners[0][1]} votes`);
    console.log(`${sortedWinners[0][0]} wins unopposed!`)
  } else if (sortedWinners[0][1] <= totalVotes/2) {
    let first = sortedWinners[0];
    let second = sortedWinners[1];
    let firstPercent = Math.floor(first[1] / totalVotes * 100);
    let secondPercent = Math.floor(second[1] / totalVotes * 100);
    console.log(`Runoff between ${first[0]} with ${firstPercent}% and ${second[0]} with ${secondPercent}%`)
  }  else {
    console.log(`${sortedWinners[0][0]} wins with ${sortedWinners[0][1]} votes`);
    console.log(`Runner up: ${sortedWinners[1][0]}`);
    let secondWSystems = [];
    for (let [system,winner] of systemWinners) {
      if (winner.has(sortedWinners[1][0])) {
        let obj = {'name':system, votes: winner.get(sortedWinners[1][0])}
        secondWSystems.push(obj);
      }
    }

    secondWSystems =secondWSystems.sort((a,b) => {
      return a.votes > b.votes ? -1 : 1;
    });

    for (let system of secondWSystems) {
      console.log(`${system.name}: ${system.votes}`);
    }
  }
}
vote([
  { system: 'Theta', candidate: 'Flying Shrimp', votes: 10 },
  { system: 'Sigma', candidate: 'Space Cow',     votes: 200 },
  { system: 'Sigma', candidate: 'Flying Shrimp', votes: 120 },
  { system: 'Tau',   candidate: 'Space Cow',     votes: 15 },
  { system: 'Sigma', candidate: 'Space Cow',     votes: 60 },
  { system: 'Tau',   candidate: 'Flying Shrimp', votes: 150 }
  ]);
console.log('****************')
vote([
  { system: 'Theta', candidate: 'Kim Jong Andromeda', votes: 10 },
  { system: 'Tau',   candidate: 'Kim Jong Andromeda', votes: 200 },
  { system: 'Tau',   candidate: 'Flying Shrimp',      votes: 150 }
  ]
);
console.log('****************')
vote([ { system: 'Tau',     candidate: 'Flying Shrimp', votes: 150 },
  { system: 'Tau',     candidate: 'Space Cow',     votes: 100 },
  { system: 'Theta',   candidate: 'Space Cow',     votes: 10 },
  { system: 'Sigma',   candidate: 'Space Cow',     votes: 200 },
  { system: 'Sigma',   candidate: 'Flying Shrimp', votes: 75 },
  { system: 'Omicron', candidate: 'Flying Shrimp', votes: 50 },
  { system: 'Omicron', candidate: 'Octocat',       votes: 75 } ]
);