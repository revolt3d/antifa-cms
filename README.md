# DRAFT December 22, 2022 THIS IS NOT COMPLETE

These are instructions to build a website using existing off-the-shelf software and no programming skills. This recipe builds out more than merely a website. In the end, you will have a complete content management and publishing system.

## About Me

I'm a software engineer. I've been building web applications and websites for more than 20 years. I'm old as hell. Over the years, I've learned a few things. One of those things I've learned is how to build a really simple website, requiring essentially no programming skills whatsoever, extremely efficient, cost-effective and fast.

I'm sharing this knowledge with people because creating a simple website is really really expensive. And figuring out how to write code is really time-consuming. With these instructions, you will be able to create a legit website in a few days of tinkering. If you know what you're doing, you can set all of this up in a matter of a couple of hours. 

## Getting Started

I will be the first to admit that this recipe is not the only way to accomplish what I'm describing here. All I'm saying is this how I do it, and it works really well.

The goal of this process is to create a robust content management system to support a public website with no programming required and extremely low hosting costs.

To make all of this cost-effective, and low-tech, we're going to use a bunch of off-the-shelf tools to make it all work for us. We're going to use GitHub.com as our content management tool. We're going to use a super-fast content management system written in PHP called Pico CMS. And we're going to use some simple Linux commands to glue it all together. That last part is a bit technical, but it's not hard to pull off.

### Requirements

Here are your ingredients.

  1. Computer for local development
  2. Docker for local development
  3. Github account (non-professional will work with a caveat - see below)
  4. Amazon AWS account for production deployment to an EC2

## Vocabulary

This guide is meant for everyone, particularly non-technical people who need a low cost website. Below are some definitions to help those who need the help.

### Amazon AWS

In this tutorial, we're going to use Amazon AWS. There are other providers of such services, but AWS is the most familiar to me. I've used Google Compute before, and it works, but I loathe Google as a company. Amazon isn't much better, but it's fine for our purposes. All of these instructions, besides setting AWS infrastructure should be the same.

### Computer

You will need a computer to build your content management system. This is where the bulk of the work is done. The computer you use should be running Mac or Linux. I'm certain these instructions would work with Windows, but I haven't used Windows in many, many years.

### Content Management System

A content management system does what it sounds like it would do - a system that manages content. In this context, content is a web page. Content could also include images that are diplayed on the web page. A content management system makes managing the web pages (e.g. content) easier.

That's what we're building here - a content management system with publishing capabilities.

### Docker

Docker is this amazing tool that you run on your computer that let's you spin up virtual servers on your computer. These little servers run pretty much like a real server will operated. We will use Docker for testing and publishing content.

This part of the process does potentially get technical, if something doesn't work correctly.

### Github
For this recipe you need a GitHub.com account. 

#### Can I use a free GitHub.com account?

The short answer is, and the long answer is maybe. It comes down to whether you want a private repository for your website code and content, or is a public repo OK? Without a paid subscription to GitHub.com, all of your code repositories are public. What that means is that anyone on GitHub.com can see your code repository. They can even propose changes to your repository, but you can just reject them if the changes aren't useful. For all intents and purposes, no one is likely to care about your GitHub.com repository. If it matters to you that your website code not be in a public repository, then pay GitHub.com $4 a month for a professional account and create a private repo.

### Linux

Linux is an open source operating system. In terms of running websites - most web servers are running some version of Linux.
