
for(i<0; i<2; i++){

let emailData = new FormData();
emailData.append('name', 'Test Yash'); 
emailData.append('email', 'yashs@riogapremium.com');
emailData.append('country', '91');
emailData.append('phone', '98765TF432');
emailData.append('type', 'Enquiry Now'); 
emailData.append('config', form.config.value || '');
emailData.append('date', form.date.value || ''); 
emailData.append('utm_source', form.utm_source.value || ''); 
emailData.append('utm_medium', form.utm_medium.value || ''); 
emailData.append('utm_campaign', form.utm_campaign.value || ''); 
emailData.append('utm_term', form.utm_term.value || ''); 
emailData.append('project_name', 'Godrej Urban Park'); 
console.log("timer 1");
return fetch('sendmail.php', { // Replace with your PHP email script
    method: 'POST',
    body: emailData
});

}