export function hasGeneralManager(roles) {
  let hasGenManager = roles.includes("general mngr");
  return hasGenManager;
}

export function hasFinanceManager(roles) {
  let hasFinancenManager = roles.includes("finance mngr");
  return hasFinancenManager;
}

export function hasHRManager(roles) {
  let hasHRManager = roles.includes("hr mngr");
  return hasHRManager;
}