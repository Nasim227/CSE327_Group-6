"use client"

import type React from "react"

import { useState } from "react"
import { Eye, EyeOff } from "lucide-react"

export default function SignupForm() {
  const [showPassword, setShowPassword] = useState(false)
  const [formData, setFormData] = useState({
    firstName: "",
    lastName: "",
    email: "",
    password: "",
    emailPreferences: false,
  })

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, type, checked, value } = e.target
    setFormData((prev) => ({
      ...prev,
      [name]: type === "checkbox" ? checked : value,
    }))
  }

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()
    // Handle form submission here
    console.log("Form submitted:", formData)
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      {/* First Name Input */}
      <div>
        <input
          type="text"
          name="firstName"
          placeholder="First Name"
          value={formData.firstName}
          onChange={handleChange}
          className="w-full px-4 py-3 bg-background border border-input rounded-lg text-foreground placeholder-foreground/50 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
          required
        />
      </div>

      {/* Last Name Input */}
      <div>
        <input
          type="text"
          name="lastName"
          placeholder="Last Name"
          value={formData.lastName}
          onChange={handleChange}
          className="w-full px-4 py-3 bg-background border border-input rounded-lg text-foreground placeholder-foreground/50 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
          required
        />
      </div>

      {/* Email Input */}
      <div>
        <input
          type="email"
          name="email"
          placeholder="Email address*"
          value={formData.email}
          onChange={handleChange}
          className="w-full px-4 py-3 bg-background border border-input rounded-lg text-foreground placeholder-foreground/50 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
          required
        />
      </div>

      {/* Password Input */}
      <div className="relative">
        <input
          type={showPassword ? "text" : "password"}
          name="password"
          placeholder="Password*"
          value={formData.password}
          onChange={handleChange}
          className="w-full px-4 py-3 bg-background border border-input rounded-lg text-foreground placeholder-foreground/50 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors pr-10"
          required
        />
        <button
          type="button"
          onClick={() => setShowPassword(!showPassword)}
          className="absolute right-3 top-1/2 -translate-y-1/2 text-foreground/50 hover:text-foreground transition-colors"
        >
          {showPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
        </button>
      </div>

      {/* Email Preferences Checkbox */}
      <div className="flex items-start gap-3 pt-2">
        <input
          type="checkbox"
          id="emailPreferences"
          name="emailPreferences"
          checked={formData.emailPreferences}
          onChange={handleChange}
          className="mt-1 w-4 h-4 rounded border-input cursor-pointer"
        />
        <label htmlFor="emailPreferences" className="text-xs text-foreground/70 leading-relaxed cursor-pointer">
          Tick here to receive emails about our products, content updates, exclusive releases and more. See our{" "}
          <a href="#" className="underline font-semibold hover:text-foreground transition-colors">
            Privacy Policy
          </a>{" "}
          and{" "}
          <a href="#" className="underline font-semibold hover:text-foreground transition-colors">
            Terms of Service
          </a>
        </label>
      </div>

      {/* Submit Button */}
      <button
        type="submit"
        className="w-full mt-6 px-6 py-3 bg-primary text-primary-foreground font-semibold rounded-full hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
      >
        CREATE ACCOUNT
      </button>
    </form>
  )
}
