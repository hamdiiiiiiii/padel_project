// DOM Elements
const loginSection = document.getElementById('loginSection');
const signupSection = document.getElementById('signupSection');
const switchToSignup = document.getElementById('switchToSignup');
const switchToLogin = document.getElementById('switchToLogin');
const loginNavBtn = document.getElementById('loginNavBtn');
const signupNavBtn = document.getElementById('signupNavBtn');

// Form elements
const signupPassword = document.getElementById('signupPassword');
const signupConfirm = document.getElementById('signupConfirmPassword');
const confirmError = document.getElementById('confirmPasswordError');

// Requirement elements
const reqLength = document.getElementById('reqLength');
const reqUpperCase = document.getElementById('reqUpperCase');
const reqLowerCase = document.getElementById('reqLowerCase');
const reqSymbol = document.getElementById('reqSymbol');

// Alert containers
const loginAlert = document.getElementById('loginAlert');
const signupAlert = document.getElementById('signupAlert');

// Helper function to show alert
function showAlert(element, message, type) {
  element.style.display = 'block';
  element.innerHTML = message;
  element.style.backgroundColor = type === 'success' ? '#d4edda' : '#f8d7da';
  element.style.color = type === 'success' ? '#155724' : '#721c24';
  element.style.border = type === 'success' ? '1px solid #c3e6cb' : '1px solid #f5c6cb';
  element.style.borderRadius = '8px';
  
  // Auto hide after 3 seconds
  setTimeout(() => {
    element.style.display = 'none';
  }, 3000);
}

// Password validation function (must include: 8+ chars, uppercase, lowercase, symbol)
function validatePasswordStrength(password) {
  const hasLength = password.length >= 8;
  const hasUpperCase = /[A-Z]/.test(password);
  const hasLowerCase = /[a-z]/.test(password);
  const hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
  
  // Update UI requirements
  updateRequirement(reqLength, hasLength, 'At least 8 characters');
  updateRequirement(reqUpperCase, hasUpperCase, 'At least one uppercase letter (A-Z)');
  updateRequirement(reqLowerCase, hasLowerCase, 'At least one lowercase letter (a-z)');
  updateRequirement(reqSymbol, hasSymbol, 'At least one symbol (!@#$%^&*)');
  
  return hasLength && hasUpperCase && hasLowerCase && hasSymbol;
}

function updateRequirement(element, isValid, text) {
  if (isValid) {
    element.classList.add('valid');
    element.classList.remove('invalid');
    element.innerHTML = '<i>✓</i> <span>' + text + '</span>';
  } else {
    element.classList.add('invalid');
    element.classList.remove('valid');
    element.innerHTML = '<i>○</i> <span>' + text + '</span>';
  }
}

// Real-time password strength check
if (signupPassword) {
  signupPassword.addEventListener('input', function() {
    validatePasswordStrength(this.value);
    checkPasswordMatch();
  });
}

// Confirm password match check
function checkPasswordMatch() {
  if (signupConfirm.value && signupPassword.value !== signupConfirm.value) {
    confirmError.textContent = 'Passwords do not match';
    return false;
  } else if (signupConfirm.value && signupPassword.value === signupConfirm.value) {
    confirmError.textContent = '';
    return true;
  }
  confirmError.textContent = '';
  return true;
}

if (signupConfirm) {
  signupConfirm.addEventListener('input', function() {
    checkPasswordMatch();
  });
}

// Switch between login and signup forms
function showLogin() {
  loginSection.style.display = 'flex';
  signupSection.style.display = 'none';
  // Clear any alerts
  if (loginAlert) loginAlert.style.display = 'none';
  if (signupAlert) signupAlert.style.display = 'none';
}

function showSignup() {
  loginSection.style.display = 'none';
  signupSection.style.display = 'flex';
  // Reset signup form validation UI
  if (signupPassword) {
    validatePasswordStrength('');
  }
  if (signupConfirm) {
    confirmError.textContent = '';
  }
  if (signupAlert) signupAlert.style.display = 'none';
  if (loginAlert) loginAlert.style.display = 'none';
}

if (switchToSignup) switchToSignup.addEventListener('click', (e) => {
  e.preventDefault();
  showSignup();
});

if (switchToLogin) switchToLogin.addEventListener('click', (e) => {
  e.preventDefault();
  showLogin();
});

if (loginNavBtn) loginNavBtn.addEventListener('click', (e) => {
  e.preventDefault();
  showLogin();
});

if (signupNavBtn) signupNavBtn.addEventListener('click', (e) => {
  e.preventDefault();
  showSignup();
});

// Login form submission
const loginForm = document.getElementById('loginForm');
if (loginForm) {
  loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value;
    
    // Simple login validation
    if (!email || !password) {
      showAlert(loginAlert, 'Please fill in all fields', 'error');
      return;
    }
    
    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      showAlert(loginAlert, 'Please enter a valid email address', 'error');
      return;
    }
    
    // Get users from localStorage
    const users = JSON.parse(localStorage.getItem('padelpro_users') || '[]');
    const user = users.find(u => u.email === email && u.password === password);
    
    if (user) {
      showAlert(loginAlert, 'Login successful! Redirecting...', 'success');
      // Store current user session
      localStorage.setItem('padelpro_current_user', JSON.stringify({ name: user.name, email: user.email }));
      setTimeout(() => {
        alert('Welcome back ' + user.name + '! (Demo: Would redirect to home page)');
      }, 1500);
    } else {
      showAlert(loginAlert, 'Invalid email or password. Please try again or sign up.', 'error');
    }
  });
}

// Signup form submission with full validation
const signupForm = document.getElementById('signupForm');
if (signupForm) {
  signupForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('signupName').value.trim();
    const email = document.getElementById('signupEmail').value.trim();
    const password = signupPassword.value;
    const confirmPassword = signupConfirm.value;
    
    // Validate name
    if (!name) {
      showAlert(signupAlert, 'Please enter your full name', 'error');
      return;
    }
    
    if (name.length < 2) {
      showAlert(signupAlert, 'Name must be at least 2 characters long', 'error');
      return;
    }
    
    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailRegex.test(email)) {
      showAlert(signupAlert, 'Please enter a valid email address', 'error');
      return;
    }
    
    // Validate password strength
    const isPasswordValid = validatePasswordStrength(password);
    if (!isPasswordValid) {
      showAlert(signupAlert, 'Password must be at least 8 characters, contain uppercase, lowercase, and a symbol (!@#$%^&*)', 'error');
      return;
    }
    
    // Check password match
    if (password !== confirmPassword) {
      showAlert(signupAlert, 'Passwords do not match', 'error');
      return;
    }
    
    // Check if email already exists
    const users = JSON.parse(localStorage.getItem('padelpro_users') || '[]');
    if (users.some(u => u.email === email)) {
      showAlert(signupAlert, 'Email already registered. Please login instead.', 'error');
      return;
    }
    
    // Save user to localStorage
    const newUser = {
      name: name,
      email: email,
      password: password,
      createdAt: new Date().toISOString()
    };
    users.push(newUser);
    localStorage.setItem('padelpro_users', JSON.stringify(users));
    
    showAlert(signupAlert, 'Account created successfully! Please login.', 'success');
    
    // Clear form
    document.getElementById('signupName').value = '';
    document.getElementById('signupEmail').value = '';
    signupPassword.value = '';
    signupConfirm.value = '';
    
    // Reset requirements UI
    validatePasswordStrength('');
    confirmError.textContent = '';
    
    // Switch to login after 2 seconds
    setTimeout(() => {
      showLogin();
      // Pre-fill email for convenience
      document.getElementById('loginEmail').value = email;
    }, 2000);
  });
}

// Initialize: check if any user is logged in
const currentPath = window.location.hash;
// Default show login if no hash
if (!window.location.hash || window.location.hash === '#login') {
  showLogin();
} else if (window.location.hash === '#signup') {
  showSignup();
}

// For demo purposes, populate with sample data if localStorage is empty
if (!localStorage.getItem('padelpro_users')) {
  const demoUsers = [
    { name: 'John Player', email: 'john@example.com', password: 'DemoPass123!', createdAt: new Date().toISOString() }
  ];
  localStorage.setItem('padelpro_users', JSON.stringify(demoUsers));
}

// Add active state to navigation based on current section
function updateNavActive() {
  const loginVisible = loginSection.style.display !== 'none';
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(link => link.classList.remove('active'));
  
  // You can customize which nav item is active based on your needs
}

// Call update on section changes
const observer = new MutationObserver(function() {
  updateNavActive();
});
observer.observe(loginSection, { attributes: true, attributeFilter: ['style'] });
observer.observe(signupSection, { attributes: true, attributeFilter: ['style'] });