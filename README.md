## Description

The goal of our project is to create a Fonction-as-a-service (FaaS) environment using OpenWhisk. Moreover, codes written in Java, Python, Node.js and PHP and external resources such as RabbitMQ and MariaDB must be supported by our FaaS environment.

## Requirements

To build and run the project, you need to have on your machine :

	- VirtualBox ( https://www.virtualbox.org/ )
	
		VirtualBox is a virtualization software. It allows to create virtual machines.
	
	- Minikube ( https://github.com/kubernetes/minikube/releases/tag/v1.0.1 )
	
		Minikube is a tool that makes it easy to run Kubernetes locally. Minikube runs a single-node Kubernetes cluster inside a VM on your laptop.
	
	- Kubectl ( https://storage.googleapis.com/kubernetes-release/release/v1.10.0/bin/windows/amd64/kubectl.exe )
	
		Kubectl is a command line interface for running commands against Kubernetes clusters.
	
	- Helm ( https://github.com/helm/helm/releases/tag/v2.14.0 )
	
		Helm is a tool to simplify the deployment and management of applications on Kubernetes clusters.
	
	- OpenWhisk CLI (wsk) ( https://github.com/apache/incubator-openwhisk-cli/releases )
		
		The OpenWhisk CLI (wsk) is the Command Line Interface offered by OpenWhisk. It allows to easily create, run and manage OpenWhisk entities.
		

Then, you can simplify accesses to Minikube, Kubectl, Helm and OpenWhisk CLI (wsk) executables by adding binary files in your PATH environment variable.

## Building & Running

To run the project, you need to open a terminal on your machine.

Then, you need to configure the Minikube virtual machine. For this, run the following commands.

`minikube config set kubernetes-version v1.10.5`
`minikube config set cpus 2`
`minikube config set memory 4096`
`minikube config set WantUpdateNotification false`

Next, you can start Minikube.

`minikube start`

This step take a few minutes. To continue, you must check the Minikube virtual machine is correctly running. The following command must show you that host, kubelect and apiserver are running and kubectl is correctly configured, so pointing to minikuve-vm.

`minikube status`

When the Minikube virtual machine is correctly running, you need to run the following command to put the docker network in promiscuous mode.

`minikube ssh -- sudo ip link set docker0 promisc on`

Then, you need to run the following command to install Tiller, the Helm server, to your running Kubernetes cluster.

`helm init`

This step take a few seconds. To continue, you must check the tiller-deploy pod in the kube-system namespace is running when you run the following command.

`kubectl get pods -n kube-system`

Then, you can run the following command to create a clusterrolebinding.

`kubectl create clusterrolebinding tiller-cluster-admin --clusterrole=cluster-admin --serviceaccount=kube-system:default`

Then, you must indicate the Kubernetes worker nodes that should be used to execute user containers by OpenWhisk's invokers.

`kubectl label nodes --all openwhisk-role=invoker`

Now, you can deploy OpenWhisk using Helm with the following command.

`helm install ./helm/openwhisk --namespace=openwhisk --name=isep -f mycluster.yaml`

This step take a few minutes. To continue, you must check the install-package pod in the openwhisk namespace is completed.

`kubectl get pods -n openwhisk`

If you want to see more information about the OpenWhisk deployment progress, you can run the following command.

`helm status isep`




## Usage

## GitHub repoository
